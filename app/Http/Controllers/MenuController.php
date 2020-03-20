<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends Controller
{
    public static function getByName($name)
    {
        return Menu::name($name)->with(['items' => function ($query)
        {
            $query->main()->enabled()->viewPermissions()->orderBy('menu_items.order');
        }, 'items.childrens' => function ($query)
        {
            $query->enabled()->viewPermissions();
        }, ])->first();
    }
}
