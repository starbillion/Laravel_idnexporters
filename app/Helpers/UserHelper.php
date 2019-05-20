<?php

function hasPermission($permission)
{
    return Auth::user()->can($permission);
}

function hasPermissionOrAbort($permission)
{
    $can = hasPermission($permission);

    if (!$can) {
        return abort(404);
    }
}

function roleGroup($group = false)
{
    if ($group == 'admin') {
        $return = ['superadmin', 'admin'];
    } elseif ($group == 'member') {
        $return = ['seller', 'buyer'];
    }

    return $return;
}

function hasRoleGroup($group = false)
{
    if ($group == 'admin') {
        if (Auth::user()->hasRole('seller') or Auth::user()->hasRole('buyer')) {
            return false;
        }

        return true;
    }

    $roles = roleGroup($group);

    return Auth::user()->hasRole($roles);
}

function getQrCode($id, $path = false)
{
    if (!is_dir(storage_path('app/public/barcodes'))) {
        Storage::makeDirectory('barcodes', 755, true, true);
    }

    if (Storage::exists('barcodes/' . $id . '.png')) {
        return $path
        ? $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . 'public/barcodes/' . $id . '.png'
        : url('storage/barcodes/' . $id . '.png');
    } else {
        $renderer = new \BaconQrCode\Renderer\Image\Png();
        $renderer->setHeight(256);
        $renderer->setWidth(256);
        $writer = new \BaconQrCode\Writer($renderer);
        $writer->writeFile(route('public.user.show', $id), storage_path('app/public/barcodes/' . $id . '.png'));

        return getQrCode($id);
    }
}

function isPackage($type, $package, $id = null)
{
    $id      = $id == null ? Auth::id() : $id;
    $package = \App\Plan::where(['type' => $type, 'name' => $package])->first();
    $user    = \App\User::find($id);

    if ($user->subscribed('main', $package->id)) {
        return true;
    }

    return false;
}

function userPackage($id = null)
{
    $id      = $id == null ? Auth::id() : $id;
    $user    = \App\User::withAnyStatus()->find($id);
    $package = $user->subscriptions()->where('canceled_at', null)->first()->plan;

    return $package;
}

function isRequestPackage()
{
    return \App\PlanRequest::where('user_id', Auth::id())->first();
}

function isPackageEnded($id = null)
{
    $user = $id ? \App\User::find($id) : \Auth::user();

    return $user->subscription('main')->ended();
}
