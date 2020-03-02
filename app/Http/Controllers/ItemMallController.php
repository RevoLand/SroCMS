<?php

namespace App\Http\Controllers;

use App\ItemMallCategory;
use Redirect;

class ItemMallController extends Controller
{
    public function __construct()
    {
        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified');
        }

        if (!setting('itemmall.enabled', 1))
        {
            Redirect::route('home')->send();
        }
    }

    public function index()
    {
        $itemMallCategories = ItemMallCategory::enabled()->with(['itemGroups' => function ($query)
            {
                $query->enabled()->active()->orderBy('order')->with([
                    'orders',
                    'items' => function ($itemsQuery)
                    {
                        $itemsQuery->enabled()->with('objCommon.name');
                    },
                ]);
            }, ])->orderBy('order')->get();

        return view('itemmall.index', compact('itemMallCategories'));
    }
}
