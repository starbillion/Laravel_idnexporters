<?php

namespace App\Http\Controllers\User\Role;

use DB;
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\Role\UpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter              = request()->input('q') ? ['name' => '%' . request()->input('q') . '%'] : null;
        $sort                = request()->input('sort') ? request()->input('sort') . ',asc' : null;
        $roles               = Role::pimp($filter, $sort);
        $this->data['roles'] = $roles->whereNotIn('name', ['superadmin', 'seller', 'buyer'])->paginate(config('app.pagination'));

        return view('role.admin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.admin.create', $this->data);
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
            $post = new Role;
            $post->fill($request->input());
            $post->save();

            DB::commit();

            return redirect()
                ->route('admin.role.edit', $post->id)
                ->with('status-success', __('role.notification_store_success', ['role' => $post->name]));

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
        $this->data['role'] = Role::find($id) or abort(404);

        return view('role.admin.edit', $this->data);
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
        $role = Role::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $role->fill($request->input());
            $role->save();

            $permissions = collect($request->input('permissions'))->keys()->map(function ($value, $key) {
                $value = [
                    'create-' . $value,
                    'read-' . $value,
                    'update-' . $value,
                    'delete-' . $value,
                ];

                return $value;
            })->flatten()->toArray();
            $permissions = Permission::whereIn('name', $permissions)->get();

            $permissions
            ? $role->syncPermissions($permissions)
            : $role->detachPermissions();

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
        $role = Role::find($id) or abort(404);

        if (User::select('id')->whereRoleIs($role->name)->count() > 0) {
            return redirect()
                ->back()
                ->with('status-error', __('role.cant_deleted'))
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $role->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('role.notification_destroy_success', ['role' => $role->name]));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
