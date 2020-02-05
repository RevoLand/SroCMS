<?php

namespace App\Http\Controllers;

use App\ItemMallCategory;

class ItemMallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified');
        }
    }

    public function index()
    {
        $itemMallCategories = ItemMallCategory::enabled()->with(['itemGroupsEnabled'])->orderBy('order')->paginate(20);

        return view('itemmall.index', compact('itemMallCategories'));
    }
}
