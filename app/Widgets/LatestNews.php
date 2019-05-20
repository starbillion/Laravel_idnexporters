<?php

namespace App\Widgets;

use App\News;
use Arrilot\Widgets\AbstractWidget;

class LatestNews extends AbstractWidget
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
        $data['posts'] = News::orderBy('id', 'desc')->limit(3)->get();

        return view('_widgets.latest_news', $data);
    }
}
