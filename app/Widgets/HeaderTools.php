<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class HeaderTools extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'search'  => [
            'status' => false,
            'route'  => null,
        ],
        'add'     => [
            'status' => false,
            'route'  => null,
        ],
        'sorts'   => [
            // 'name'    => 'Name',
            // 'created' => 'Created',
        ],
        'filters' => [
            // [
            //     'name'  => 'Status',
            //     'input' => 'status',
            //     'data'  => [
            //         'active' => 'Active',
            //     ],
            // ],
        ],
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data           = [];
        $data['config'] = $this->config;

        return view('_widgets.header_tools', $data);
    }
}
