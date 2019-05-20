<?php

namespace App\Widgets;

use App\Endorsement;
use Arrilot\Widgets\AbstractWidget;

class Endorsements extends AbstractWidget
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
        $data['endorsements'] = Endorsement::get();

        return view('_widgets.endorsements', $data);
    }
}
