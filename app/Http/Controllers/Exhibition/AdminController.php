<?php

namespace App\Http\Controllers\Exhibition;

use DB;
use App\Country;
use App\Exhibitor;
use App\Exhibition as Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exhibition\StoreRequest;
use App\Http\Requests\Exhibition\UpdateRequest;

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
            'mode'      => 'or',
            'title'     => $q,
            'organizer' => $q,
            'venue'     => $q,
        ];
        $filter = request()->input('q') ? $filters : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts  = Post::pimp($filter, $sort);

        $this->data['posts'] = $posts->paginate(config('app.pagination'));

        return view('exhibition.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['countries'] = Country::orderBy('name')->get();

        return view('exhibition.admin.create', $this->data);
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
            $post->slug = $request->input('slug') ? $request->input('slug') : str_slug($request->input('title'), '-');
            $post->save();

            DB::commit();

            return redirect()
                ->route('admin.exhibition.edit', $post->id)
                ->with('status-success', __('exhibition.notification_store_success', ['exhibition' => $post->title]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.exhibition.create')
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
        $this->data['post']       = Post::find($id) or abort(404);
        $this->data['countries']  = Country::orderBy('name')->get();
        $this->data['exhibitors'] = Exhibitor::orderBy('name')->get();

        return view('exhibition.admin.edit', $this->data);
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
            $post->slug = $request->input('slug') ? $request->input('slug') : str_slug($request->input('title'), '-');
            $post->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('exhibition.notification_update_success', ['exhibition' => $post->title]));

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
                ->route('admin.exhibition.index')
                ->with('status-success', __('exhibition.notification_destroy_success', ['exhibition' => $post->title]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
