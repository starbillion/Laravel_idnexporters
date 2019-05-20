<?php

namespace App\Http\Controllers\User;

use Auth;
use App\User;
use App\Country;
use App\Language;
use App\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ProfileUpdateRequest as UpdateRequest;

class MemberController extends Controller
{
    public function show($id)
    {
        $this->data['user'] = User::find($id);

        return view('user.member.show', $this->data);
    }

    public function general()
    {
        $this->data['user'] = Auth::user();

        return view('user.member.general', $this->data);
    }

    public function company()
    {
        $this->data['user']      = Auth::user();
        $this->data['countries'] = Country::get();
        $this->data['languages'] = Language::get();

        return view('user.member.company', $this->data);
    }

    public function profile()
    {
        $this->data['user'] = Auth::user();

        return view('user.member.profile', $this->data);
    }

    public function category()
    {
        $this->data['user']       = Auth::user();
        $this->data['categories'] = ProductCategory::whereIsRoot()->get();

        return view('user.member.category', $this->data);
    }

    public function banners()
    {
        if (!Auth::user()->subscription('main')->ability()->canUse('company_banners')) {
            return abort(404);
        }

        $this->data['user'] = Auth::user();

        return view('user.member.banners', $this->data);
    }

    public function media()
    {
        $this->data['user'] = Auth::user();

        return view('user.member.media', $this->data);
    }

    public function complete()
    {
        $this->data['countries'] = Auth::user()->hasRole('seller')
        ? Country::where('name', 'Indonesia')->get()
        : Country::get();
        $this->data['user'] = Auth::user();

        return view('user.member.complete', $this->data);
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->input());

        if ($categories = $request->input('categories')) {
            $user->categories = $categories;
        } else {
            $user->categories = [];
        }

        return $user->save()
        ? redirect()
            ->back()
            ->with('status-success', __('user.notification_profile_success'))
        : redirect()
            ->back()
            ->with('status-error', __('general.notification_general_error'))
            ->withInput();
    }
}
