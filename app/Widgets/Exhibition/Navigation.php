<?php

namespace App\Widgets\Exhibition;

use Arrilot\Widgets\AbstractWidget;

class Navigation extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'post' => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //

        return view('_widgets.exhibition.navigation', $this->config);
    }
}
