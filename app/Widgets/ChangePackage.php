<?php

namespace App\Widgets;

use Auth;
use App\Plan;
use Arrilot\Widgets\AbstractWidget;

class ChangePackage extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    protected $data   = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $this->data['plans'] = Plan::get();
        $this->data['type']  = Auth::user()->hasRole('seller') ? 'seller' : 'buyer';

        return view('_widgets.change_package', $this->data);
    }
}
