<?php

return [

    'pdf'   => [
        'enabled' => true,
        'binary'  => 'xvfb-run /usr/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => 'xvfb-run /usr/bin/wkhtmltoimg',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
