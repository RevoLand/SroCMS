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
        $itemMallCategories = ItemMallCategory::enabled()->with(['itemGroups' => function ($query)
            {
                $query->enabled()->orderBy('order')->with(['items' => function ($itemsQuery)
                    {
                        $itemsQuery->enabled()->with('objCommon.name');
                    }, ]);
            }, ])->orderBy('order')->get();

        return view('itemmall.index', compact('itemMallCategories'));
    }
}
