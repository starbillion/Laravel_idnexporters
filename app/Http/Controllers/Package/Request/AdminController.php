<?php

namespace App\Http\Controllers\Package\Request;

use DB;
use App\PlanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Package\Member\SendInvoice;

class AdminController extends Controller
{
    public function index()
    {
        $this->data['requests'] = PlanRequest::paginate(config('app.pagiantion'));

        return view('package.admin.index', $this->data);
    }

    public function update(Request $request, $id)
    {
        $requested = PlanRequest::find($id) or abort(404);
        $status    = $request->input('status');

        switch ($status) {
            /******** CONFIRM ********/
            case 'confirm':
                DB::beginTransaction();

                try {
                    $requested->user->subscriptions()->delete();
                    $requested->user->newSubscription('main', $requested->plan)->create();

                    if (($products = $requested->user->products()->withAnyStatus()->count()) > 0) {
                        $requested->user->subscriptionUsage('main')->record('products', $products);
                    }

                    $requested->delete();

                    $requested->user->notify(new SendInvoice($requested, true));

                    DB::commit();

                    return redirect()
                        ->back()
                        ->with('status-success', __('package.notification_update_success'));

                } catch (Exception $e) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->with('status-error', __('general.notification_general_error'))
                        ->withInput();
                }
                break;

            /******** CANCEL ********/
            case 'cancel':
                DB::beginTransaction();

                try {
                    $requested->delete();

                    DB::commit();

                    return redirect()
                        ->back()
                        ->with('status-success', __('package.notification_update_success'));

                } catch (Exception $e) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->with('status-error', __('general.notification_general_error'))
                        ->withInput();
                }
                break;
            default:
                return abort(404);
                break;
        }
    }
}
