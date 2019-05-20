<?php

function createMenu($data, $use_icon = true)
{
    $menu = Menu::new ()->addClass('nav-main');

    foreach ($data as $link) {
        $link['title'] = __($link['title']);
        $icon          = isset($link['icon']) ? '<i class="' . $link['icon'] . '"></i>' : '<i class="si si-link"></i>';

        if (isset($link['children'])) {
            $menu->html('
            	<a class="nav-submenu" data-toggle="nav-submenu" href="#">' .
                ($use_icon ? $icon : '') .
                $link['title'] .
                '</a>' .
                createMenu($link['children'], false));
        } else {

            if (isset($link['route'])) {
                $route  = $link['route'][0];
                $params = isset($link['route'][1]) ? $link['route'][1] : false;

                $params
                ? $menu->add(
                    \Spatie\Menu\Laravel\Link::toRoute($route, ($use_icon ? $icon : null) . $link['title'], $params)
                        ->setAttribute('class')
                        ->addClass(Route::currentRouteName() == $route ? 'active' : '')
                )
                : $menu->add(
                    \Spatie\Menu\Laravel\Link::toRoute($route, ($use_icon ? $icon : null) . $link['title'])
                        ->setAttribute('class')
                        ->addClass(Route::currentRouteName() == $route ? 'active' : '')
                );

            } elseif (isset($link['url'])) {
                $menu
                    ->url($link['url'], ($use_icon ? $icon : null) . $link['title'])
                    ->setAttribute('class')
                    ->addClass(Route::currentRouteName() == $link['url'] ? 'active' : '');
            }

        }
    }

    return $menu;
}

function moduleMenus()
{
    $default = config('menus.backend.sidebar_menu');
    $menus   = [];

    if ($default) {
        $menus = createMenu($default);
    }

    return $menus;
}
