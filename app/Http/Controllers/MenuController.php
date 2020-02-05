<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public static function getMenus($location = null, $limit = null)
    {
        return Menu::enabled()->main()->where(function ($query) use ($location)
        {
            if (isset($location))
            {
                $query->location($location);
            }

            if (Auth::check())
            {
                $query->where('users_can_view', true);
            }
            else
            {
                $query->where('guests_can_view', true);
            }
        })->with('page')->withCount('childMenus')->orderBy('order')->limit($limit)->get();
    }
}
