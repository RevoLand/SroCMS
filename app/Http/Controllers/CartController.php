<?php

namespace App\Http\Controllers;

use Alert;
use App\ItemMallItemGroup;

class CartController extends Controller
{
    public function __construct()
    {
        if (setting('users.email_must_be_verified', 0))
        {
            $this->middleware('verified');
        }
    }

    public function additem(ItemMallItemGroup $itemgroup)
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

    public function index()
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

        return view('itemmall.cart', ['cart' => $cart, 'totals' => $this->getTotals(), 'itemCount' => $this->getCount()]);
    }

    public function update()
    {
        request()->validate([
            'groupid' => ['required', 'integer', 'exists:App\ItemMallItemGroup,id'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $cart = session()->get('cart');

        if (!$cart)
        {
            return response()->json(['message' => 'Herhangi bir sepet oluşturmamışsınız.'], 400);
        }

        if (!array_key_exists(request()->groupid, $cart))
        {
            return response()->json(['message' => 'Güncellemeye çalıştığınız ürün sepetinizde bulunmamaktadır.'], 400);
        }

        if (request()->quantity === 0)
        {
            unset($cart[request()->groupid]);
            session()->put('cart', $cart);

            return response()->json(['totals' => $this->getTotals(), 'quantity' => 0, 'itemCount' => $this->getCount(), 'message' => 'Ürün sepetinizden silindi.']);
        }

        $cart[request()->groupid]['quantity'] = request()->quantity;
        session()->put('cart', $cart);

        return response()->json(['totals' => $this->getTotals(), 'quantity' => request()->quantity, 'itemCount' => $this->getCount(), 'message' => 'Ürün miktarı başarıyla güncellendi.']);
    }

    public function delete(ItemMallItemGroup $itemgroup)
    {
        $cart = session()->get('cart') ?? [];

        if (!array_key_exists($itemgroup->id, $cart))
        {
            return response()->json(['message' => 'Geçersiz ürün gönderildi. Zaten sepetinizden silinmiş olabilir?'], 400);
        }

        unset($cart[$itemgroup->id]);
        session()->put('cart', $cart);

        return response()->json(['totals' => $this->getTotals(), 'itemCount' => $this->getCount(), 'message' => 'Ürün sepetinizden silindi.']);
    }

    private function getTotals()
    {
        $cart = session()->get('cart') ?? [];
        $totals = [];

        foreach ($cart as $cartItem)
        {
            if (array_key_exists($cartItem['group']->payment_type, $totals))
            {
                $totals[$cartItem['group']->payment_type]['price'] += $cartItem['group']->price * $cartItem['quantity'];
            }
            else
            {
                $totals[$cartItem['group']->payment_type] = [
                    'price' => $cartItem['group']->price * $cartItem['quantity'],
                    'name' => config('constants.payment_types.' . $cartItem['group']->payment_type),
                ];
            }
        }

        return $totals;
    }

    private function getCount()
    {
        $cart = session()->get('cart') ?? [];
        $itemCount = 0;

        foreach ($cart as $cartItem)
        {
            $itemCount += $cartItem['quantity'];
        }

        return $itemCount;
    }
}
