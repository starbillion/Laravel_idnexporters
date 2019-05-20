<?php

namespace App\Http\Controllers\User\Admin;

use DB;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Http\Requests\Admin\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter               = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort                 = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $admins               = User::pimp($filter, $sort);
        $this->data['admins'] = $admins->whereHas('roles', function ($q) {
            $q->whereNotIn('name', [
                'superadmin',
                'seller',
                'buyer',
            ]);
        })->paginate(config('app.pagination'));

        return view('admin.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['roles'] = Role::whereNotIn('name', [
            'superadmin',
            'seller',
            'buyer',
        ])->get();

        return view('admin.admin.create', $this->data);
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
            $post            = new User;
            $post->name      = $request->input('name');
            $post->email     = $request->input('email');
            $post->password  = $request->input('password');
            $post->verified  = 1;
            $post->active    = 1;
            $post->status    = 1;
            $post->languages = [39];
            $post->save();

            $role = Role::find($request->input('role_id'));
            $post->attachRole($role);

            DB::commit();

            return redirect()
                ->route('admin.admin.edit', $post->id)
                ->with('status-success', __('admin.notification_store_success', ['admin' => $post->name]));

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
        $this->data['admin'] = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', [
                'superadmin',
                'seller',
                'buyer',
            ]);
        })->find($id) or abort(404);
        $this->data['roles'] = Role::whereNotIn('name', [
            'superadmin',
            'seller',
            'buyer',
        ])->get();

        return view('admin.admin.edit', $this->data);
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
        $user = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', [
                'superadmin',
                'seller',
                'buyer',
            ]);
        })->find($id) or abort(404);

        DB::beginTransaction();

        try {
            $user->name     = $request->input('name');
            $user->email    = $request->input('email');
            $user->password = $request->input('password');
            $user->save();

            $role = Role::find($request->input('role_id'));
            $user->syncRoles([$role->id]);

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('role.notification_update_success', ['role' => $role->name]));

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
        $user = User::whereHas('roles', function ($q) {
            $q->whereNotIn('name', [
                'superadmin',
                'seller',
                'buyer',
            ]);
        })->find($id) or abort(404);

        DB::beginTransaction();

        try {
            $user->delete();
            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('user.notification_destroy_success', ['user' => $user->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
