<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends Controller
{
    public static function getMenus($location = null, $limit = null)
    {
        return dd(Menu::whereEnabled(true)->where(function ($query) use ($location)
        {
            if (isset($location))
            {
                $query->whereLocation($location);
            }
        })->orderBy('order')->limit($limit));
    }
}
