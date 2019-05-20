<?php

namespace App\Http\Controllers\Message;

use DB;
use App\User;
use App\MessengerThread;
use Illuminate\Routing\Controller;
use Cmgmyr\Messenger\Models\Thread;

class AdminController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $model = MessengerThread::withTrashed();

        switch (request()->input('status')) {
            case 'pending':
                $model->where('status', 0)->where('deleted_at', null);
                break;
            case 'approved':
                $model->where('status', 1);
                break;
            case 'deleted':
                $model->where('deleted_at', '!=', null);
                break;
        }

        $this->data['threads'] = $model->orderBy('id', 'desc')->paginate(config('app.pagination'));

        return view('message.admin.index', $this->data);
    }

    public function update($id)
    {
        $post = MessengerThread::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $post->status = true;
            $post->save();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('message.notification_update_success'));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $post = MessengerThread::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $post->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('status-success', __('message.notification_destroy_success'));

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
