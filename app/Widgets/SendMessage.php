<?php

namespace App\Widgets;

use Auth;
use App\MessengerThread;
use Arrilot\Widgets\AbstractWidget;

class SendMessage extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type'    => false,
        'user'    => false,
        'product' => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data   = [];
        $exists = MessengerThread::between([Auth::id(), $this->config['user']->id])
            ->latest('updated_at')
            ->first();

        $data['exists'] = $exists;

        if ($this->config['user']) {
            $data['user'] = $this->config['user'];
        }

        if ($this->config['product']) {
            $data['product'] = $this->config['product'];
        }

        $data['type'] = $this->config['type'];

        return view('_widgets.send_message', $data);
    }
}
