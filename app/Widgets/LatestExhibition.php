<?php

namespace App\Widgets;

use Carbon\Carbon;
use App\Exhibition;
use Arrilot\Widgets\AbstractWidget;

class LatestExhibition extends AbstractWidget
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
        $data['posts'] = Exhibition::where('start_at', '>=', Carbon::now())
            ->where('featured', true)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('_widgets.latest_exhibition', $data);
    }
}
