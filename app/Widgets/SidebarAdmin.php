<?php

namespace App\Widgets;

use App\User;
use App\PlanRequest;
use App\ProductPost;
use App\MessengerThread;
use Arrilot\Widgets\AbstractWidget;

class SidebarAdmin extends AbstractWidget
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
        $data['user']['sellers']  = User::pending()->whereRoleIs('seller')->count();
        $data['user']['buyers']   = User::pending()->whereRoleIs('buyer')->count();
        $data['user']['package']  = PlanRequest::count();
        $data['product']['posts'] = ProductPost::pending()->has('owner')->count();
        $data['message']['posts'] = MessengerThread::where('status', false)->count();

        return view('_widgets.sidebar_admin', $data);
    }
}
