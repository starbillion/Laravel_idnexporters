<?php

namespace App\Http\Controllers\Faq\Post;

use DB;
use App\FaqPost as Post;
use Illuminate\Http\Request;
use App\FaqCategory as Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\Post\StoreRequest;
use App\Http\Requests\Faq\Post\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = request()->input('q') ? ['question' => '%' . request()->input('q') . '%'] : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts  = Post::pimp($filter, $sort);

        if ($category_id = request()->input('category_id')) {
            $posts->where('category_id', $category_id);
        }

        $this->data['posts'] = $posts->paginate(config('app.pagination'));

        return view('faq.post.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['categories'] = Category::get();

        return view('faq.post.admin.create', $this->data);
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

            DB::commit();

            return redirect()
                ->route('admin.faq.post.edit', $post->id)
                ->with('status-success', __('faq.post_data.notification_store_success', ['post' => $post->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.faq.post.create')
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
        $this->data['categories'] = Category::get();
        $this->data['post']       = Post::find($id) or abort(404);

        return view('faq.post.admin.edit', $this->data);
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

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('faq.post_data.notification_update_success', ['post' => $post->name]));

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
            $post->delete();

            DB::commit();

            return redirect()
                ->route('admin.faq.post.index')
                ->with('status-success', __('faq.post_data.notification_destroy_success', ['post' => $post->name]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
