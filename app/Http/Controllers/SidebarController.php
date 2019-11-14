<?php

namespace App\Http\Controllers;

use App\Sidebar;

class SidebarController extends Controller
{
    public static function getSidebars($limit)
    {
        return Sidebar::where('enabled', true)->orderBy('order')->take($limit)->get();
    }
}
