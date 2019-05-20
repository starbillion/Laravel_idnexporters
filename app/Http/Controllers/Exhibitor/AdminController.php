<?php

namespace App\Http\Controllers\Exhibitor;

use DB;
use App\Country;
use App\Exhibition;
use App\ProductCategory;
use App\Exhibitor as Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibitor\StoreRequest;
use App\Http\Requests\Exhibitor\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q       = '%' . request()->input('q') . '%';
        $filters = [
            'name' => $q,
        ];
        $filter = request()->input('q') ? $filters : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts  = Post::pimp($filter, $sort);

        $this->data['posts'] = $posts->paginate(config('app.pagination'));

        return view('exhibitor.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['exhibitions'] = Exhibition::get();
        $this->data['countries']   = Country::orderBy('name')->get();
        $this->data['categories']  = ProductCategory::whereIsRoot()->get();

        return view('exhibitor.admin.create', $this->data);
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
            $post = new Post;
            $post->fill($request->input());
            $post->save();

            $exhibitions = collect($request->input('exhibitions'))
                ->map(function ($item) {
                    if (isset($item['exhibition'])) {
                        return $item;
                    }
                })
                ->filter()
                ->keyBy('exhibition')
                ->map(function ($item) {
                    unset($item['exhibition']);

                    return $item;
                })
                ->toArray();

            $post->exhibitions()->sync($exhibitions);

            DB::commit();

            return $request->input('save')
            ? redirect()
                ->route('admin.exhibitor.create')
                ->with('status-success', __('exhibitor.notification_store_success', ['exhibitor' => $post->title]))
            : redirect()
                ->route('admin.exhibitor.edit', $post->id)
                ->with('status-success', __('exhibitor.notification_store_success', ['exhibitor' => $post->title]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.exhibitor.create')
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
        $this->data['exhibitions'] = Exhibition::get();
        $this->data['post']        = Post::find($id) or abort(404);
        $this->data['countries']   = Country::orderBy('name')->get();
        $this->data['categories']  = ProductCategory::whereIsRoot()->get();

        return view('exhibitor.admin.edit', $this->data);
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
        $post = Post::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $post->fill($request->input());
            $post->save();

            $exhibitions = collect($request->input('exhibitions'))
                ->map(function ($item) {
                    if (isset($item['exhibition'])) {
                        return $item;
                    }
                })
                ->filter()
                ->keyBy('exhibition')
                ->map(function ($item) {
                    unset($item['exhibition']);

                    return $item;
                })
                ->toArray();

            $post->exhibitions()->sync($exhibitions);

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('exhibitor.notification_update_success', ['exhibitor' => $post->title]));

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
        $post = Post::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $post->exhibitions()->detach();
            $post->delete();

            DB::commit();

            return redirect()
                ->route('admin.exhibitor.index')
                ->with('status-success', __('exhibitor.notification_destroy_success', ['exhibitor' => $post->title]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
