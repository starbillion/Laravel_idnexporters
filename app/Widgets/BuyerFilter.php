<?php

namespace App\Widgets;

use App\Country;
use Arrilot\Widgets\AbstractWidget;

class BuyerFilter extends AbstractWidget
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
        $data['countries'] = Country::whereHas('user', function ($q) {
            return $q->where('status', 1)->whereRoleIs(['buyer']);
        })->orderBy('name', 'asc')->get();

        return view('user.public.widgets.buyer_filter', $data);
    }
}
