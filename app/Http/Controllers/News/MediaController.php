<?php

namespace App\Http\Controllers\News;

use App\News;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store($id)
    {
        $validator = Validator::make(request()->all(), [
            'featured_image' => [
                'required',
                'image',
                Rule::dimensions()
                    ->maxWidth(2000)
                    ->maxHeight(2000),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('status-error', $validator->errors()->first('featured_image'))
                ->withInput();
        }

        $endorsement = News::where(['id' => $id])->first() or abort(404);
        $endorsement->clearMediaCollection('featured_image');

        return $endorsement
            ->addMediaFromRequest('featured_image')
            ->usingFileName(md5(time()))
            ->toMediaCollection('featured_image')
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
        $endorsement = News::where(['id' => $id])->first() or abort(404);
        $endorsement->clearMediaCollection('featured_image');

        return redirect()
            ->back()
            ->with('status-success', __('endorsement.notification_update_success'))
            ->withInput();

    }
}
