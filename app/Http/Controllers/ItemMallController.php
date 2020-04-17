<?php

namespace App\Http\Controllers;

use App\ItemMallCategory;
use DB;
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
            $query->enabled()->active()->with([
                'items' => function ($itemsQuery)
                {
                    $itemsQuery->enabled()->with('objCommon.name');
                },
            ])->withCount([
                'userOrders' => function ($query)
                {
                    $query->select(DB::raw('sum(quantity)'));
                },
                'orders' => function ($query)
                {
                    $query->select(DB::raw('sum(quantity)'));
                },
            ])->orderByDesc('featured')->orderBy('order')->whereHas('items');
        }, ])->get();

        return view('itemmall.index', compact('itemMallCategories'));
    }
}
