<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends Controller
{
    public static function getMenus($location = null, $limit = null)
    {
        return Menu::whereEnabled(true)->where(function ($query) use ($location)
        {
            if (isset($location))
            {
                $query->whereLocation($location);
            }
        })->with('page')->orderBy('order')->limit($limit)->get();
    }
}
