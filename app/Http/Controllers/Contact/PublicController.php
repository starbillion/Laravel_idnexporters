<?php

namespace App\Http\Controllers\Contact;

use DB;
use App\Contact;
use App\Http\Controllers\Controller;
use App\Notifications\Contact\ThankYou;
use App\Http\Requests\Contact\StoreRequest;

class PublicController extends Controller
{
    public function create()
    {
        return view('contact.public.create', $this->data);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $post = new Contact;
            $post->fill($request->input());
            $post->save();
            $post->notify(new ThankYou($post));

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('contact.notification_store_success'));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
