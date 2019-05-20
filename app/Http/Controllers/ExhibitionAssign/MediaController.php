<?php

namespace App\Http\Controllers\ExhibitorAssign;

use Validator;
use App\Exhibitor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store($id)
    {
        $validator = Validator::make(request()->all(), [
            'logo' => [
                'required',
                'image',
                Rule::dimensions()
                    ->maxWidth(500)
                    ->maxHeight(500)
                    ->ratio(1 / 1),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('status-error', $validator->errors()->first('logo'))
                ->withInput();
        }

        $exhibitor = Exhibitor::where(['id' => $id])->first() or abort(404);
        $exhibitor->clearMediaCollection('logo');

        return $exhibitor
            ->addMediaFromRequest('logo')
            ->usingFileName(md5(time()))
            ->toMediaCollection('logo')
        ? redirect()
            ->back()
            ->with('status-success', __('exhibitor.notification_update_success', ['exhibitor' => $exhibitor->name]))
            ->withInput()
        : redirect()
            ->back()
            ->with('status-error', __('general.notification_general_error'))
            ->withInput();
    }

    public function destroy($id)
    {
        $exhibitor = Exhibitor::where(['id' => $id])->first() or abort(404);
        $exhibitor->clearMediaCollection('logo');

        return redirect()
            ->back()
            ->with('status-success', __('exhibitor.notification_update_success', ['exhibitor' => $exhibitor->name]))
            ->withInput();

    }
}
