<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Logo extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'type'         => 'text', // text, image
        'image_source' => 'img/logo.png',
        'url'          => 'index',
    ];

    /**
     * Run
     */
    public function run()
    {
        return view('_widgets.logo', $this->config);
    }

    public function placeholder()
    {
        return 'Loading...';
    }
}
