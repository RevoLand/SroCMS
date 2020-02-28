<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends Controller
{
    public static function getMenus($location = null, $limit = null)
    {
        return Menu::enabled()->main()->viewPermissions()->where(function ($query) use ($location)
        {
            if (isset($location))
            {
                $query->location($location);
            }
        })->with(['page' => function ($query)
            {
                $query->enabled();
            }, ])->withCount('childMenus')->orderBy('order')->limit($limit)->get();
    }
}
