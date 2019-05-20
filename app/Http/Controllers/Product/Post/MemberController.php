<?php

namespace App\Http\Controllers\Product\Post;

use DB;
use Auth;
use App\Currency;
use Notification;
use App\ProductPost;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewProduct;
use App\Http\Requests\Product\Post\StoreRequest;
use App\Http\Requests\Product\Post\UpdateRequest;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter   = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort     = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $status   = request()->input('status');
        $products = ProductPost::pimp($filter, $sort);

        switch ($status) {
            case 'pending':
                $products->pending();
                break;
            case 'approved':
                $products->approved();
                break;
            default:
                $products->withPending();
                break;
        }

        $count_total    = ProductPost::withPending()->count();
        $count_pending  = ProductPost::pending()->count();
        $count_approved = ProductPost::approved()->count();

        if (Auth::user()->hasRole('seller')) {
            $products->where('user_id', Auth::id());
            $count_total    = ProductPost::where('user_id', Auth::id())->withPending()->count();
            $count_pending  = ProductPost::where('user_id', Auth::id())->pending()->count();
            $count_approved = ProductPost::where('user_id', Auth::id())->approved()->count();
        }

        $this->data['products'] = $products->paginate(config('app.pagination'));
        $this->data['count']    = [
            'total'    => $count_total,
            'pending'  => $count_pending,
            'approved' => $count_approved,
        ];

        return view('product.post.member.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->subscription('main')->ability()->remainings('products') <= 0 or isRequestPackage()) {
            return abort(404);
        }

        $this->data['currencies'] = Currency::get();

        if (old('category_id-1') or old('category_id-2') or old('category_id-3')) {
            $this->data['categories']['data'][1]     = ProductCategory::whereIsRoot()->get();
            $this->data['categories']['selected'][1] = old('category_id-1');

            $this->data['categories']['data'][2]     = ProductCategory::where('parent_id', old('category_id-1'))->get();
            $this->data['categories']['selected'][2] = old('category_id-2');

            $this->data['categories']['data'][3]     = ProductCategory::where('parent_id', old('category_id-2'))->get();
            $this->data['categories']['selected'][3] = old('category_id-3');
        } else {
            $this->data['categories'] = [
                'data'     => [
                    1 => ProductCategory::whereIsRoot()->get(),
                    2 => [],
                    3 => [],
                ],
                'selected' => [
                    1 => null,
                    2 => null,
                    3 => null,
                ],
            ];
        }

        return view('product.post.member.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Auth::user()->subscription('main')->ability()->remainings('products') <= 0) {
            return abort(404);
        }

        DB::beginTransaction();

        try {
            $product = new ProductPost;
            $product->fill($request->input());
            $product->category_id = $request->input('category_id-3');
            $product->user_id     = Auth::id();
            $product->save();
            Auth::user()->subscriptionUsage('main')->record('products');

            if ($recipients = config('emails.admin.new_product.recipients')) {
                $recipients = explode(',', $recipients);

                foreach ($recipients as $recipient) {
                    Notification::route('mail', trim($recipient))->notify(new NewProduct($product));
                }
            }

            DB::commit();

            return redirect()
                ->route('member.product.post.edit', $product->id)
                ->with('status-success', __('product/post.notification_store_success', ['product' => $product->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('member.product.post.create')
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['product']    = ProductPost::withPending()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);
        $this->data['currencies'] = Currency::get();

        if (old('category_id-1') or old('category_id-2') or old('category_id-3')) {
            $this->data['categories']['data'][1]     = ProductCategory::whereIsRoot()->get();
            $this->data['categories']['selected'][1] = old('category_id-1');

            $this->data['categories']['data'][2]     = ProductCategory::where('parent_id', old('category_id-1'))->get();
            $this->data['categories']['selected'][2] = old('category_id-2');

            $this->data['categories']['data'][3]     = ProductCategory::where('parent_id', old('category_id-2'))->get();
            $this->data['categories']['selected'][3] = old('category_id-3');
        } else {
            $ancestors = ProductCategory::ancestorsOf($this->data['product']->category_id)->toArray();

            $this->data['categories'] = [
                'data'     => [
                    1 => ProductCategory::whereIsRoot()->get(),
                    2 => ProductCategory::where('parent_id', $ancestors[0]['id'])->get(),
                    3 => ProductCategory::where('parent_id', $ancestors[1]['id'])->get(),
                ],
                'selected' => [
                    1 => $ancestors[0]['id'],
                    2 => $ancestors[1]['id'],
                    3 => $this->data['product']->category_id,
                ],
            ];
        }

        return view('product.post.member.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = ProductPost::withPending()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);

        DB::beginTransaction();

        try {
            $product->fill($request->input());
            $product->category_id = $request->input('category_id-3');
            $product->user_id     = Auth::id();
            $product->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('product/post.notification_update_success', ['product' => $product->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductPost::withPending()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);

        DB::beginTransaction();

        try {
            $product->delete();
            $product->clearMediaCollection('product');
            Auth::user()->subscriptionUsage('main')->reduce('products');

            DB::commit();

            return redirect()
                ->route('member.product.post.index')
                ->with('status-success', __('product/post.notification_destroy_success', ['product' => $product->name]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
