<?php

namespace App\Http\Controllers;

use Alert;
use App\ItemMallCategory;
use App\ItemMallItemGroup;

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

    public function addtocart(ItemMallItemGroup $itemgroup)
    {
        if (!$itemgroup->enabled)
        {
            Alert::error('Hata!', 'Geçersiz ürün.');

            return back();
        }

        if (!$itemgroup->items()->enabled()->count())
        {
            Alert::error('Hata!', 'Bu ürün grubunda herhangi bir ürün tanımlaması yapılmadığı için ürün sepete eklenemiyor!');

            return back();
        }

        $cart = session()->get('cart') ?? [];

        if (!array_key_exists($itemgroup->id, $cart))
        {
            $cart[$itemgroup->id] = [
                'quantity' => 1,
                'group' => $itemgroup,
            ];

            Alert::success('Ürün sepete eklendi');
        }
        else
        {
            ++$cart[$itemgroup->id]['quantity'];
            Alert::success('Sepetteki ürün miktarı artırıldı');
        }
        session()->put('cart', $cart);

        return back();
    }

    public function cart()
    {
        $cart = session()->get('cart') ?? [];

        foreach ($cart as $key => $cartItem)
        {
            $cartItem['group']->refresh();
            if (!$cartItem['group']->enabled || !$cartItem['group']->items()->enabled()->count())
            {
                unset($cart[$key]);
                session()->flash('status', $cartItem['group']->name . ' adlı ürün aktif olmadığı gerekçesiyle sepetinizden çıkarıldı.');
            }
        }

        // Yapılan değişiklikleri kaydet.
        session()->put('cart', $cart);

        return view('itemmall.cart', compact('cart'));
    }
}
