<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class RenewPackage extends AbstractWidget
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
        //

        return view('_widgets.renew_package', []);
    }
}
