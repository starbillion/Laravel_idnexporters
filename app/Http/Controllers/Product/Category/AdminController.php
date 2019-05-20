<?php

namespace App\Http\Controllers\Product\Category;

use DB;
use App\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\Category\StoreRequest as StoreRequest;
use App\Http\Requests\Product\Category\UpdateRequest as UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter                   = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort                     = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts                    = ProductCategory::pimp($filter, $sort)->whereIsRoot();
        $this->data['categories'] = $posts->paginate(config('app.pagination'));

        return view('product.category.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($parent = request()->input('parent')) {
            $this->data['category']  = ProductCategory::find($parent) or abort(404);
            $this->data['ancestors'] = $this->data['category']->ancestors;

            if (count($this->data['ancestors']) == 2) {
                return abort(404);
            }
        }

        return view('product.category.admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if ($parent = request()->input('parent')) {
            $this->data['category']  = ProductCategory::find($parent) or abort(404);
            $this->data['ancestors'] = $this->data['category']->ancestors;

            if (count($this->data['ancestors']) == 2) {
                return abort(404);
            }
        }

        DB::beginTransaction();

        try {
            if ($parent) {
                $post = $this->data['category']->children()->create($request->input());
            } else {
                $post = new ProductCategory;
                $post->fill($request->input());
                $post->save();
            }

            DB::commit();

            return redirect()
                ->route('admin.product.category.edit', $post->id)
                ->with('status-success', __('product/category.notification_store_success', ['category' => $post->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['category']   = ProductCategory::find($id) or abort(404);
        $this->data['ancestors']  = $this->data['category']->ancestors;
        $filter                   = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort                     = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts                    = $this->data['category']->children()->pimp($filter, $sort);
        $this->data['categories'] = $posts->paginate(config('app.pagination'));

        return view('product.category.admin.edit', $this->data);
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
        DB::beginTransaction();

        try {
            $category = ProductCategory::find($id) or abort(404);
            $category->fill($request->input());
            $category->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('product/category.notification_update_success', ['category' => $category->name]));

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
        $category = ProductCategory::find($id) or abort(404);

        if (count($category->descendants) > 0) {
            return redirect()
                ->back()
                ->with('status-error', __('product/category.cant_deleted'))
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $category->delete();

            DB::commit();

            if (request()->input('parent')) {
                return redirect()
                    ->back()
                    ->with('status-success', __('product/category.notification_destroy_success', ['category' => $category->name]));
            } else {
                return redirect()
                    ->route('admin.product.category.index')
                    ->with('status-success', __('product/category.notification_destroy_success', ['category' => $category->name]));
            }

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
