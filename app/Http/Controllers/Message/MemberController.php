<?php

namespace App\Http\Controllers\Message;

use DB;
use App\User;
use Carbon\Carbon;
use App\MessengerThread;
use App\MessengerMessage;
use App\MessengerParticipant;
use Illuminate\Routing\Controller;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Requests\Message\UpdateRequest;

class MemberController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        $threads = MessengerThread::where('status', true)
            ->forUser(Auth::id())
            ->latest('updated_at')
            ->whereHas('participants.user', function ($q) {
                $q->whereIn('status', [0, 1, 2, 3, 4, 5, 6, 7]);
            })
            ->orWhere('created_by', Auth::id())
            ->groupBy('messenger_threads.id')
            ->paginate(config('app.pagination'));

        return view('message.member.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $thread = MessengerThread::where('id', $id)
            ->whereHas('users', function ($q) {
                $q->where('user_id', Auth::id());
            })->first() or abort(404);
        $thread->markAsRead(Auth::id());

        $to       = $thread->participants()->where('user_id', '!=', Auth::id())->first()->user;
        $messages = $thread->messages()->orderBy('id', 'desc')->paginate(config('app.pagination'));

        return view('message.member.show', compact('thread', 'messages', 'to'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        $threads = MessengerThread::between([Auth::id(), $request->input('recipient')])->latest('updated_at')->count();

        if ($threads > 0) {
            return abort(404);
        }

        DB::beginTransaction();

        try {
            $thread             = new MessengerThread;
            $thread->status     = false;
            $thread->created_by = Auth::id();
            $thread->save();

            // Message
            MessengerMessage::create([
                'thread_id'  => $thread->id,
                'user_id'    => Auth::id(),
                'product_id' => $request->input('product_id'),
                'body'       => $request->input('body'),
            ]);

            // Sender
            MessengerParticipant::create([
                'thread_id' => $thread->id,
                'user_id'   => Auth::id(),
                'last_read' => new Carbon,
            ]);

            $thread->addParticipant($request->input('recipient'));

            DB::commit();

            return redirect()->route('member.message.show', $thread->id);

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update(UpdateRequest $request, $id)
    {
        $thread = MessengerThread::find($id) or abort(404);

        DB::beginTransaction();

        try {
            $thread->activateAllParticipants();

            // Message
            MessengerMessage::create([
                'thread_id'  => $thread->id,
                'user_id'    => Auth::id(),
                'product_id' => $request->input('product_id'),
                'body'       => $request->input('body'),
            ]);

            // Sender
            $participant            = MessengerParticipant::where(['thread_id' => $thread->id, 'user_id' => Auth::id()])->first();
            $participant->last_read = new Carbon;
            $participant->save();

            DB::commit();

            return redirect()->route('member.message.show', $thread->id);

        } catch (Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('status-error', __('general.notification_general_error'))
                ->withInput();
        }
    }
}
