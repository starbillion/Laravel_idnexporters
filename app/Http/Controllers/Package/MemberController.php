<?php

namespace App\Http\Controllers\Package;

use DB;
use Auth;
use App\Plan;
use App\Coupon;
use Notification;
use App\PlanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewPackageRequest;
use App\Notifications\Package\Member\SendInvoice;

class MemberController extends Controller
{
    public function index()
    {
        if (request()->input('status') == 1) {
            $this->data['requested'] = PlanRequest::where('user_id', Auth::id())->first() or abort(404);

            return view('package.member.thank_you', $this->data);
        } else {
            $this->data['requested'] = PlanRequest::where('user_id', Auth::id())->first();
            $this->data['type']      = Auth::user()->hasRole('seller') ? 'seller' : 'buyer';
            $this->data['plans']     = Plan::where('type', $this->data['type'])->get();

            return view('package.member.index', $this->data);
        }
    }

    public function store(Request $request)
    {
        $coupon = null;
        $plan   = Plan::find($request->input('package')) or abort(404);

        // Exists?
        if (PlanRequest::where('user_id', Auth::id())->count()) {
            return abort(404);
        }

        if ($plan->promo and ($code = request()->input('promo'))) {
            $coupon = Coupon::where('code', $code)->first();

            if (!$coupon) {
                return redirect()
                    ->back()
                    ->with('status-error', __('package.notification_coupon_error'));
            }

            $coupon = $coupon->id;
        }

        DB::beginTransaction();

        try {
            $req            = new PlanRequest;
            $req->user_id   = Auth::id();
            $req->plan_id   = $plan->id;
            $req->coupon_id = $coupon;
            $req->save();

            if ($recipients = config('emails.admin.new_package_request.recipients')) {
                $recipients = explode(',', $recipients);

                foreach ($recipients as $recipient) {
                    Notification::route('mail', trim($recipient))->notify(new NewPackageRequest());
                }
            }

            $req->user->notify(new SendInvoice($req, false));

            DB::commit();

            return redirect()
                ->route('member.package.index', ['status' => 1]);

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
