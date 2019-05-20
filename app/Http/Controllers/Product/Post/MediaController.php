<?php

namespace App\Http\Controllers\Product\Post;

use Auth;
use Validator;
use App\ProductPost;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class MediaController extends Controller
{
    public function store($id)
    {
        $validator = Validator::make(request()->all(), [
            'product' => [
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
                ->with('status-error', $validator->errors()->first('product'))
                ->withInput();
        }

        $product = ProductPost::withAnyStatus()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);
        $product->clearMediaCollection('product');

        return $product
            ->addMediaFromRequest('product')
            ->usingFileName(md5(time()))
            ->toMediaCollection('product')
        ? redirect()
            ->back()
            ->with('status-success', __('user.notification_profile_success'))
            ->withInput()
        : redirect()
            ->back()
            ->with('status-error', __('general.notification_general_error'))
            ->withInput();
    }

    public function destroy($id)
    {
        $product = ProductPost::withAnyStatus()->where(['user_id' => Auth::id(), 'id' => $id])->first() or abort(404);
        $product->clearMediaCollection('product');

        return redirect()
            ->back()
            ->with('status-success', __('user.notification_profile_success'))
            ->withInput();

    }
}
