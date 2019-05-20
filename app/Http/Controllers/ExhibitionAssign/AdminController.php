<?php

namespace App\Http\Controllers\ExhibitionAssign;

use App\Exhibitor;
use App\Exhibition as Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExhibitionAssign\StoreRequest;
use App\Http\Requests\ExhibitionAssign\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $q       = '%' . request()->input('q') . '%';
        $filters = [
            'name' => $q,
        ];
        $filter                   = request()->input('q') ? $filters : null;
        $sort                     = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $this->data['exhibition'] = Post::find($id) or abort(404);
        $posts                    = $this->data['exhibition']->exhibitors()->pimp($filter, $sort);
        $this->data['posts']      = $posts->paginate(config('app.pagination'));

        return view('exhibition_assign.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $this->data['exhibition'] = Post::find($id) or abort(404);
        $this->data['exhibitors'] = Exhibitor::whereNotIn('id', $this->data['exhibition']->exhibitors()->pluck('id'))->get();

        return view('exhibition_assign.admin.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $id)
    {
        $post = Post::find($id) or abort(404);

        $post->exhibitors()
            ->attach($request->input('exhibitor_id'), [
                'booth' => $request->input('booth'),
            ]);

        return redirect()
            ->route('admin.exhibition_assign.edit', [$id, $request->input('exhibitor_id')])
            ->with('status-success', __('exhibition.notification_exhibitor_update_success'));
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
    public function edit($id, $exhibitor_id)
    {
        $this->data['exhibition'] = Post::find($id) or abort(404);
        $this->data['exhibitor']  = $this->data['exhibition']->exhibitors()->where('exhibitor_id', $exhibitor_id)->withPivot('booth')->first() or abort(404);

        return view('exhibition_assign.admin.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id, $exhibitor_id)
    {
        $post = Post::find($id) or abort(404);

        $post->exhibitors()
            ->detach($exhibitor_id);
        $post->exhibitors()
            ->attach($exhibitor_id, [
                'booth' => $request->input('booth'),
            ]);

        return redirect()
            ->route('admin.exhibition_assign.edit', [$id, $exhibitor_id])
            ->with('status-success', __('exhibition.notification_exhibitor_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $exhibitor_id)
    {
        $post = Post::find($id) or abort(404);
        $post->exhibitors()->detach($exhibitor_id);

        return redirect()
            ->back()
            ->with('status-success', __('exhibition.notification_exhibitor_update_success'));
    }
}
