<?php

namespace App\Http\Controllers\Faq\Category;

use DB;
use Illuminate\Http\Request;
use App\FaqCategory as Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\Category\StoreRequest;
use App\Http\Requests\Faq\Category\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter     = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort       = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $categories = Category::pimp($filter, $sort);

        $this->data['categories'] = $categories->paginate(config('app.pagination'));

        return view('faq.category.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faq.category.admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $category = new Category;
            $category->fill($request->input());
            $category->save();

            DB::commit();

            return redirect()
                ->route('admin.faq.category.edit', $category->id)
                ->with('status-success', __('faq.category_data.notification_store_success', ['category' => $category->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.faq.category.create')
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
        $this->data['category'] = Category::find($id) or abort(404);

        return view('faq.category.admin.edit', $this->data);
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
        $category = Category::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $category->fill($request->input());
            $category->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('faq.category_data.notification_update_success', ['category' => $category->name]));

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
        $category = Category::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $category->delete();

            DB::commit();

            return redirect()
                ->route('admin.faq.category.index')
                ->with('status-success', __('faq.category_data.notification_destroy_success', ['category' => $category->name]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
