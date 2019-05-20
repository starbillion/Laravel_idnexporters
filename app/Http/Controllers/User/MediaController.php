<?php

namespace App\Http\Controllers\User;

use Auth;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store($type = null)
    {
        if (!Auth::user()->subscription('main')->ability()->canUse('company_logo')) {
            return abort(404);
        }

        if (!Auth::user()->subscription('main')->ability()->canUse('company_banners')) {
            return abort(404);
        }

        switch (request()->input('type')) {
            case 'logo':
                $validator = Validator::make(request()->all(), [
                    'logo' => [
                        'required',
                        'image',
                        Rule::dimensions()
                            ->maxWidth(500)
                            ->maxHeight(500),
                    ],
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('status-error', $validator->errors()->first('logo'))
                        ->withInput();
                }

                Auth::user()->clearMediaCollection('logo');

                return Auth::user()
                    ->addMediaFromRequest('logo')
                    ->usingFileName(md5(time()))
                    ->toMediaCollection('logo')
                ? redirect()
                    ->back()
                    ->with('status-success', __('user.user.notification_profile_success'))
                    ->withInput()
                : redirect()
                    ->back()
                    ->with('status-error', __('general.notification_general_error'))
                    ->withInput();
                break;
            case 'banner':

                if (!$id = request()->input('id')) {
                    return abort(404);
                }

                if ($id > 4 or $id < 0) {
                    return abort(404);
                }

                $validator = Validator::make(request()->all(), [
                    'banner' => [
                        'required',
                        'image',
                        Rule::dimensions()
                            ->maxWidth(900)
                            ->maxHeight(300),
                    ],
                ]);

                if ($validator->fails()) {
                    return redirect()
                        ->back()
                        ->with('status-error', $validator->errors()->first('banner'))
                        ->withInput();
                }

                $mediaItems = Auth::user()->getMedia('banner');

                foreach ($mediaItems as $media) {
                    if ($media->hasCustomProperty('id')) {
                        if ($media->getCustomProperty('id') == $id) {
                            $media->delete();
                        }
                    }
                }

                return Auth::user()
                    ->addMediaFromRequest('banner')
                    ->usingFileName(md5(time()))
                    ->withCustomProperties(['id' => $id])
                    ->toMediaCollection('banner')
                ? redirect()
                    ->back()
                    ->with('status-success', __('user.user.notification_profile_success'))
                    ->withInput()
                : redirect()
                    ->back()
                    ->with('status-error', __('general.notification_general_error'))
                    ->withInput();
                break;

            default:
                return abort(404);
                break;
        }

    }

    public function destroy($id)
    {
        switch (request()->input('type')) {
            case 'logo':
                Auth::user()->clearMediaCollection('logo');

                return redirect()
                    ->back()
                    ->with('status-success', __('user.notification_profile_success'))
                    ->withInput();
                break;
            case 'banner':
                Auth::user()->media()->find($id)->delete();

                return redirect()
                    ->back()
                    ->with('status-success', __('user.notification_profile_success'))
                    ->withInput();
                break;

            default:
                return abort(404);
                break;

        }
    }
}
