<?php

return [

    'backend' => [
        'sidebar_menu' => [
            [
                'title' => 'general.dashboard',
                'route' => ['dashboard'],
                'icon'  => 'si si-graph',
            ],
            [
                'title'    => 'general.users',
                'route'    => ['dashboard'],
                'icon'     => 'si si-people',
                'children' => [
                    [
                        'title' => 'general.list',
                        'route' => ['user.index'],
                    ],
                    [
                        'title' => 'general.add',
                        'route' => ['user.create'],
                    ],
                ],
            ],
        ],
    ],

];
