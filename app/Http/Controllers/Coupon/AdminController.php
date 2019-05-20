<?php

namespace App\Http\Controllers\Coupon;

use DB;
use App\Coupon as Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreRequest;
use App\Http\Requests\Coupon\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = request()->input('q') ? ['code' => '%' . request()->input('q') . '%'] : null;
        $sort   = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $posts  = Post::pimp($filter, $sort);

        $this->data['posts'] = $posts->paginate(config('app.pagination'));

        return view('coupon.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.admin.create', $this->data);
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
                ->route('admin.coupon.edit', $post->id)
                ->with('status-success', __('coupon.notification_store_success', ['coupon' => $post->code]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.coupon.create')
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
        $this->data['post'] = Post::find($id) or abort(404);

        return view('coupon.admin.edit', $this->data);
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
                ->with('status-success', __('coupon.notification_update_success', ['coupon' => $post->code]));

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
                ->route('admin.coupon.index')
                ->with('status-success', __('coupon.notification_destroy_success', ['coupon' => $post->code]));
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
