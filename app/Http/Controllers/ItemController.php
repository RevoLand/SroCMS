<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Support\Facades\Redirect;

class ItemController extends Controller
{
    public function __construct()
    {
        if (!setting('items.enable_items_page', 0))
        {
            Redirect::route('home')->send();
        }

        if (setting('items.show_item_requires_auth', 1))
        {
            $this->middleware('auth');
        }
    }

    public function show(Item $item)
    {
        return view('user.items.show', compact('item'));
    }
}
