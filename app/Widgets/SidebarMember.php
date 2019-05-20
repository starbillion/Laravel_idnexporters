<?php

namespace App\Widgets;

use Auth;
use Arrilot\Widgets\AbstractWidget;
use Cmgmyr\Messenger\Models\Thread;

class SidebarMember extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data = [
            'message_count' => Thread::where('status', true)
                ->forUserWithNewMessages(Auth::id())->latest('updated_at')
                ->count(),
        ];

        return view('_widgets.sidebar_member', $data);
    }
}
