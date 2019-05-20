<?php

namespace App\Widgets;

use Auth;
use App\PlanRequest;
use Arrilot\Widgets\AbstractWidget;
use Gerardojbaez\LaraPlans\Models\Plan;

class AccountUpgrade extends AbstractWidget
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
        $data['requested'] = PlanRequest::where('user_id', Auth::id())->first();
        $data['plans']     = Plan::where([
            ['name', '!=', 'regular'],
            ['type', '=', Auth::user()->hasRole('seller') ? 'seller' : 'buyer'],
        ])->get();

        return view('_widgets.account_upgrade', $data);
    }
}
