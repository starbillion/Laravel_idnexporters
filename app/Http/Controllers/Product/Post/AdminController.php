<?php

namespace App\Http\Controllers\Product\Post;

use DB;
use App\Currency;
use App\ProductPost;
use App\ProductCategory;
use App\Http\Controllers\Controller;
use Gerardojbaez\LaraPlans\Models\Plan;
use App\Notifications\Product\MemberApproved;
use App\Notifications\Product\MemberRejected;
use App\Http\Requests\Product\Post\UpdateRequest as UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = ProductPost::select('*');

        switch (request()->input('status')) {
            case 'pending':
                $posts->pending();
                break;
            case 'approved':
                $posts->approved();
                break;
            case 'rejected':
                $posts->rejected();
                break;
            default:
                $posts->withAnyStatus();
                break;
        }

        $posts->has('owner');

        $q      = '%' . request()->input('q') . '%';
        $search = [
            'name' => $q,
        ];
        $filter = request()->input('q') ? $search : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts->pimp($filter, $sort);

        if ($seller = request()->input('seller')) {
            $posts->where('user_id', $seller);
        }

        $this->data['packages'] = Plan::get();
        $this->data['products'] = $posts->paginate(config('app.pagination'));
        $this->data['count']    = [
            'total'    => ProductPost::withAnyStatus()->has('owner')->count(),
            'pending'  => ProductPost::pending()->has('owner')->count(),
            'approved' => ProductPost::approved()->has('owner')->count(),
            'rejected' => ProductPost::rejected()->has('owner')->count(),
        ];

        return view('product.post.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {

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
        $this->data['product']    = ProductPost::withAnyStatus()->find($id) or abort(404);
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

        return view('product.post.admin.edit', $this->data);
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
        $product = ProductPost::withAnyStatus()->find($id) or abort(404);

        DB::beginTransaction();

        try {
            if ($request->input('status')) {
                switch ($request->input('status')) {
                    case 'pending':
                        $product->markPending();
                        break;
                    case 'approved':
                        $product->markApproved();
                        $product->owner->notify(new MemberApproved($product));
                        break;
                    case 'rejected':
                        $product->markRejected();
                        $product->owner->subscriptionUsage('main')->reduce('products');
                        $product->owner->notify(new MemberRejected($product));
                        break;
                    default:
                        return abort(404);
                        break;
                }
            } else {
                $product->fill($request->input());
                $product->category_id = $request->input('category_id-3');
                $product->save();
            }

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
        $product = ProductPost::withAnyStatus()->find($id) or abort(404);

        DB::beginTransaction();

        try {
            $product->delete();
            $product->clearMediaCollection('product');

            if (!$product->isRejected()) {
                $product->owner->subscriptionUsage('main')->reduce('products');
            }

            DB::commit();

            return redirect()
                ->back()
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
