<?php

namespace App\Http\Controllers\Endorsement;

use Validator;
use App\Endorsement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store($id)
    {
        $validator = Validator::make(request()->all(), [
            'logo' => [
                'required',
                'image',
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('status-error', $validator->errors()->first('logo'))
                ->withInput();
        }

        $endorsement = Endorsement::where(['id' => $id])->first() or abort(404);
        $endorsement->clearMediaCollection('logo');

        return $endorsement
            ->addMediaFromRequest('logo')
            ->usingFileName(md5(time()))
            ->toMediaCollection('logo')
        ? redirect()
            ->back()
            ->with('status-success', __('endorsement.notification_update_success'))
            ->withInput()
        : redirect()
            ->back()
            ->with('status-error', __('general.notification_general_error'))
            ->withInput();
    }

    public function destroy($id)
    {
        $endorsement = Endorsement::where(['id' => $id])->first() or abort(404);
        $endorsement->clearMediaCollection('logo');

        return redirect()
            ->back()
            ->with('status-success', __('endorsement.notification_update_success'))
            ->withInput();

    }
}
