<?php

namespace App\Http\Controllers;

use Alert;
use App\ItemMallItemGroup;
use Auth;
use Redirect;

class CartController extends Controller
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

    public function additem(ItemMallItemGroup $itemgroup)
    {
        if (!$itemgroup->enabled)
        {
            Alert::error('Hata!', 'Geçersiz ürün.');

            return back();
        }

        if (!$itemgroup->active)
        {
            Alert::error('Hata!', 'Bu ürün grubu satışa açık değil!');

            return back();
        }

        if (!$itemgroup->items()->enabled()->count())
        {
            Alert::error('Hata!', 'Bu ürün grubunda herhangi bir ürün tanımlaması yapılmadığı için ürün sepete eklenemiyor!');

            return back();
        }

        if (!$this->checkTotalPurchaseLimit($itemgroup, 0, true))
        {
            Alert::error('Hata!', 'Bu üründen daha fazla satın alınamaz!');

            return back();
        }

        if (!$this->checkUserPurchaseLimit($itemgroup, 0, true))
        {
            Alert::error('Hata!', 'Bu üründen daha fazla satın alamazsınız.');

            return back();
        }

        $cart = session('cart', []);

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
        $cart = session('cart', []);

        foreach ($cart as $key => $cartItem)
        {
            $cartItem['group']->refresh();
            if (!$cartItem['group']->enabled || !$cartItem['group']->items()->enabled()->count() || !$cartItem['group']->active)
            {
                unset($cart[$key]);
                session()->flash('status', $cartItem['group']->name . ' adlı ürün aktif olmadığı gerekçesiyle sepetinizden çıkarıldı.');
            }

            if (!$this->checkTotalPurchaseLimit($cartItem['group']) || !$this->checkUserPurchaseLimit($cartItem['group']))
            {
                unset($cart[$key]);
                session()->flash('status', $cartItem['group']->name . ' adlı üründe yeterli stok bulunmamaktadır.');
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

        $cart[request()->groupid]['group']->refresh();
        if (request()->quantity <= 0 || !$cart[request()->groupid]['group']->active)
        {
            unset($cart[request()->groupid]);
            session()->put('cart', $cart);

            return response()->json(['totals' => $this->getTotals(), 'quantity' => 0, 'itemCount' => $this->getCount(), 'message' => 'Ürün sepetinizden silindi.']);
        }

        if (!$this->checkTotalPurchaseLimit($cart[request()->groupid]['group'], request()->quantity))
        {
            return response()->json(['message' => 'Bu üründen daha fazla satın alamazsınız.'], 403);
        }

        if (!$this->checkUserPurchaseLimit($cart[request()->groupid]['group'], request()->quantity))
        {
            return response()->json(['message' => 'Bu üründen daha fazla satın alamazsınız.'], 403);
        }

        $cart[request()->groupid]['quantity'] = request()->quantity;
        session()->put('cart', $cart);

        return response()->json(['totals' => $this->getTotals(), 'quantity' => request()->quantity, 'itemCount' => $this->getCount(), 'message' => 'Ürün miktarı başarıyla güncellendi.']);
    }

    public function delete(ItemMallItemGroup $itemgroup)
    {
        $cart = session('cart', []);

        if (!array_key_exists($itemgroup->id, $cart))
        {
            return response()->json(['message' => 'Geçersiz ürün gönderildi. Zaten sepetinizden silinmiş olabilir?'], 400);
        }

        unset($cart[$itemgroup->id]);
        session()->put('cart', $cart);

        return response()->json(['totals' => $this->getTotals(), 'itemCount' => $this->getCount(), 'message' => 'Ürün sepetinizden silindi.']);
    }

    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) < 1)
        {
            Alert::error('Hata!', 'Sepetinizde ürün olmadığı için satın alma işlemi gerçekleştirilemiyor.');

            return back();
        }

        foreach ($cart as $key => $cartItem)
        {
            $cartItem['group']->refresh();

            if (!$cartItem['group']->enabled || !$cartItem['group']->active || !$cartItem['group']->items()->enabled()->count())
            {
                Alert::error('Hata!', 'Sepetinizdeki bir veya daha fazla ürün aktif değil.');

                return back();
            }

            if (!$this->checkTotalPurchaseLimit($cartItem['group']))
            {
                Alert::error('Hata!', $cartItem['group']->name . ' adlı ürünün toplam satın alım limitine ulaşıldı.');

                unset($cart[$key]);
                session()->put('cart', $cart);

                return back();
            }

            if (!$this->checkUserPurchaseLimit($cartItem['group']))
            {
                Alert::error('Hata!', $cartItem['group']->name . ' adlı ürün için satın alım limitine ulaştınız.');

                unset($cart[$key]);
                session()->put('cart', $cart);

                return back();
            }
        }

        $canAfford = false;
        foreach ($this->getTotals() as $key => $total)
        {
            switch ($key)
            {
                default:
                Alert::error('Hata!', 'Sepetinizdeki ürünlerden bir veya daha fazlası geçersiz bir ödeme tipine sahip.');

                return back();
                // Bakiye
                case 1:
                    $canAfford = (bcsub(Auth::user()->balance->balance, $total['price'], 2) >= 0);
                break;
                // Bakiye (Puan)
                case 2:
                    $canAfford = (bcsub(Auth::user()->balance->balance_point, $total['price'], 2) >= 0);
                break;
                // Silk
                case 3:
                    $canAfford = (Auth::user()->silk->silk_own - $total['price'] >= 0);
                break;
                // Silk (Gift)
                case 4:
                    $canAfford = (Auth::user()->silk->silk_gift - $total['price'] >= 0);
                break;
                // Silk (Point)
                case 5:
                    $canAfford = (Auth::user()->silk->silk_point - $total['price'] >= 0);
                break;
            }

            if (!$canAfford)
            {
                Alert::error('Hata!', 'Yetersiz bakiye.');

                return back();
            }
        }

        $order = Auth::user()->orders()->create();
        foreach ($cart as $cartItem)
        {
            $itemGroup = $cartItem['group'];
            switch ($itemGroup->payment_type)
            {
                // Bakiye
                case config('constants.payment_types.balance'):
                    $itemPrice = bcmul($itemGroup->price, $cartItem['quantity'], 2);
                    Auth::user()->balance->decrease('balance', $itemPrice, config('constants.balance.source.itemmall'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                break;
                // Bakiye (Puan)
                case config('constants.payment_types.balance_point'):
                    $itemPrice = bcmul($itemGroup->price, $cartItem['quantity'], 2);
                    Auth::user()->balance->decrease('balance_point', $itemPrice, config('constants.balance.source.itemmall'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                break;
                // Silk
                case config('constants.payment_types.silk'):
                    $itemPrice = $itemGroup->price * $cartItem['quantity'];
                    Auth::user()->silk->decrease(config('constants.silk.type.id.silk_own'), $itemPrice, config('constants.silk.reason.dec.silk_own'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                break;
                // Silk (Gift)
                case config('constants.payment_types.silk_gift'):
                    $itemPrice = $itemGroup->price * $cartItem['quantity'];
                    Auth::user()->silk->decrease(config('constants.silk.type.id.silk_gift'), $itemPrice, config('constants.silk.reason.dec.silk_gift'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                break;
                // Silk (Point)
                case config('constants.payment_types.silk_point'):
                    $itemPrice = $itemGroup->price * $cartItem['quantity'];
                    Auth::user()->silk->decrease(config('constants.silk.type.id.silk_point'), $itemPrice, config('constants.silk.reason.dec.silk_point'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                break;
            }

            /*
                referrals.commissions_enabled | bool | 0
                referrals.commission_allowed_payment_types | smallInteger | 1 **(bitwise)**
                referrals.commission_reward_type | tinyint | 2
                referrals.commission_earned_percentage | integer | 2

                $table->boolean('use_customized_referral_options')->default(false);
                $table->boolean('referral_commission_enabled')->default(true);
                $table->tinyInteger('referral_commission_reward_type')->default(2);
                $table->tinyInteger('referral_commission_percentage')->default(1)->nullable();
            */

            // Referans sistemi kontrolleri
            if (setting('referrals.commissions_enabled', 0) && Auth::user()->referrer && (!$itemGroup->use_customized_referral_options || ($itemGroup->use_customized_referral_options && $itemGroup->referral_commission_enabled))
                && setting('referrals.commission_allowed_payment_types', 1) & config('constants.itemmall.limitations.from_payment_type.' . $itemGroup->payment_type))
            {
                $referralPoints = bcdiv(bcmul($itemPrice, (($itemGroup->use_customized_referral_options && isset($itemGroup->referral_commission_percentage)) ? $itemGroup->referral_commission_percentage : setting('referrals.commission_earned_percentage', 2)), 2), 100, 2);

                switch (($itemGroup->use_customized_referral_options) ? $itemGroup->referral_commission_reward_type : setting('referrals.commission_reward_type', 2))
                {
                    case config('constants.payment_types.balance'):
                        Auth::user()->referrer->referrerUser->balance->increase('balance', $referralPoints, config('constants.balance.source.referred_user_reward'), 'Referansı olunan kullanıcının yaptığı alışverişten kazanıldı.', Auth::user()->JID);
                    break;
                    case config('constants.payment_types.balance_point'):
                        Auth::user()->referrer->referrerUser->balance->increase('balance_point', $referralPoints, config('constants.balance.source.referred_user_reward'), 'Referansı olunan kullanıcının yaptığı alışverişten kazanıldı.', Auth::user()->JID);
                    break;
                    case config('constants.payment_types.silk'):
                        Auth::user()->referrer->referrerUser->silk->increase(config('constants.silk.type.id.silk_own'), intval($referralPoints), config('constants.silk.reason.inc.silk_own'), 'Referansı olunan kullanıcının yaptığı alışverişten kazanıldı. Kullanıcı: ' . Auth::user()->getName());
                    break;
                    case config('constants.payment_types.silk_gift'):
                        Auth::user()->referrer->referrerUser->silk->increase(config('constants.silk.type.id.silk_gift'), intval($referralPoints), config('constants.silk.reason.inc.silk_gift'), 'Referansı olunan kullanıcının yaptığı alışverişten kazanıldı. Kullanıcı: ' . Auth::user()->getName());
                    break;
                    case config('constants.payment_types.silk_point'):
                        Auth::user()->referrer->referrerUser->silk->increase(config('constants.silk.type.id.silk_point'), intval($referralPoints), config('constants.silk.reason.inc.silk_point'), 'Referansı olunan kullanıcının yaptığı alışverişten kazanıldı. Kullanıcı: ' . Auth::user()->getName());
                    break;
                }
            }
            /*
                itemmall.pointrewards.enabled | bool | true
                itemmall.pointrewards.allowed_payment_types | smallInteger | 1 **(bitwise)**
                itemmall.pointrewards.percentage | tinyInteger | 2

                $table->boolean('use_customized_point_options')->default(false);
                $table->boolean('reward_point_enabled')->default(true);
                $table->tinyInteger('reward_point_type')->default(2);
                $table->tinyInteger('reward_point_percentage')->default(1)->nullable();
            */

            if (setting('itemmall.pointrewards.enabled', 1) && (!$itemGroup->use_customized_point_options || ($itemGroup->use_customized_point_options && $itemGroup->reward_point_enabled))
                && setting('itemmall.pointrewards.allowed_payment_types', 1) & config('constants.itemmall.limitations.from_payment_type.' . $itemGroup->payment_type))
            {
                $pointReward = bcdiv(bcmul($itemPrice, $itemGroup->use_customized_point_options && isset($itemGroup->reward_point_percentage) ? $itemGroup->reward_point_percentage : setting('itemmall.pointrewards.percentage', 2), 2), 100, 2);

                switch (($itemGroup->use_customized_point_options) ? $itemGroup->reward_point_type : $itemGroup->payment_type)
                {
                    case config('constants.payment_types.balance'):
                        Auth::user()->balance->increase('balance', $pointReward, config('constants.balance.source.itemmall_reward'), 'Item Mall\'da yapılan alışverişten kazanıldı.');
                    break;
                    case config('constants.payment_types.balance_point'):
                        Auth::user()->balance->increase('balance_point', $pointReward, config('constants.balance.source.itemmall_reward'), 'Item Mall\'da yapılan alışverişten kazanıldı.');
                    break;
                    case config('constants.payment_types.silk'):
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_own'), intval($pointReward), config('constants.silk.reason.inc.silk_own'), 'Item Mall\'da yapılan alışverişten kazanıldı.');
                    break;
                    case config('constants.payment_types.silk_gift'):
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_gift'), intval($pointReward), config('constants.silk.reason.inc.silk_gift'), 'Item Mall\'da yapılan alışverişten kazanıldı.');
                    break;
                    case config('constants.payment_types.silk_point'):
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_point'), intval($pointReward), config('constants.silk.reason.inc.silk_point'), 'Item Mall\'da yapılan alışverişten kazanıldı.');
                    break;
                }
            }

            $order->items()->create([
                'item_mall_item_group_id' => $itemGroup->id,
                'user_id' => Auth::user()->JID,
                'quantity' => $cartItem['quantity'],
                'payment_type' => $itemGroup->payment_type,
                'item_price' => $itemGroup->price,
                'total_paid' => $itemPrice,
                'points_earned' => $pointReward ?? 0,
            ]);

            foreach ($itemGroup->items()->enabled()->get() as $item)
            {
                /*
                    "type" => "6"
                    "codename" => "ITEM_MALL_GLOBAL_CHATTING"
                    "amount" => "5"
                    "balance" => ".00"
                    "plus" => "0"
                */
                switch ($item->type)
                {
                    // Bakiye
                    case 1:
                        Auth::user()->balance->increase('balance', bcmul($item->balance, $cartItem['quantity'], 2), config('constants.balance.source.itemmall'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alımından gelen bakiye.");
                    break;
                    // Bakiye (Puan)
                    case 2:
                        Auth::user()->balance->increase('balance_point', bcmul($item->balance, $cartItem['quantity'], 2), config('constants.balance.source.itemmall'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alımından gelen bakiye.");
                    break;
                    // Silk
                    case 3:
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_own'), $item->amount * $cartItem['quantity'], config('constants.silk.reason.inc.silk_own'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                    break;
                    // Silk (Gift)
                    case 4:
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_gift'), $item->amount * $cartItem['quantity'], config('constants.silk.reason.inc.silk_gift'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                    break;
                    // Silk (Point)
                    case 5:
                        Auth::user()->silk->increase(config('constants.silk.type.id.silk_point'), $item->amount * $cartItem['quantity'], config('constants.silk.reason.inc.silk_point'), "{$cartItem['quantity']} adet {$itemGroup->name} ({$itemGroup->id}) satın alım ücreti.");
                    break;
                    // Item
                    case 6:
                        $maxStack = $item->objCommon->objItem->MaxStack;
                        $amountToGive = $item->amount * $cartItem['quantity'];

                        while ($amountToGive > 0)
                        {
                            Auth::user()->addChestItem($item->codename, ($maxStack % $amountToGive === $maxStack) ? $maxStack : $amountToGive, $item->plus);

                            $amountToGive -= $maxStack;
                        }
                    break;
                }
            }
        }

        // Sepeti boşalt
        session()->forget('cart');

        Alert::success('Satın alma işlemi başarıyla gerçekleşti.');

        return redirect()->route('itemmall.index');
    }

    private function getTotals()
    {
        $cart = session('cart', []);
        $totals = [];

        foreach ($cart as $cartItem)
        {
            if (array_key_exists($cartItem['group']->payment_type, $totals))
            {
                $totals[$cartItem['group']->payment_type]['price'] = bcadd($totals[$cartItem['group']->payment_type]['price'], bcmul($cartItem['group']->price, $cartItem['quantity'], 2), 2);
            }
            else
            {
                $totals[$cartItem['group']->payment_type] = [
                    'price' => bcmul($cartItem['group']->price, $cartItem['quantity'], 2),
                    'name' => config('constants.payment_types.' . $cartItem['group']->payment_type),
                ];
            }
        }

        return $totals;
    }

    private function getCount()
    {
        $cart = session('cart', []);
        $itemCount = 0;

        foreach ($cart as $cartItem)
        {
            $itemCount += $cartItem['quantity'];
        }

        return $itemCount;
    }

    private function checkTotalPurchaseLimit(ItemMallItemGroup $itemGroup, int $quantity = 0, $add = false): bool
    {
        if (!$itemGroup->limit_total_purchases)
        {
            return true;
        }

        if (!$quantity)
        {
            $cart = session('cart', []);
            if (array_key_exists($itemGroup->id, $cart))
            {
                $quantity = $cart[$itemGroup->id]['quantity'];
            }

            if ($add)
            {
                ++$quantity;
            }
        }

        return ($itemGroup->totalOrders + $quantity) <= $itemGroup->total_purchase_limit;
    }

    private function checkUserPurchaseLimit(ItemMallItemGroup $itemGroup, int $quantity = 0, $add = false): bool
    {
        if (!$itemGroup->limit_user_purchases)
        {
            return true;
        }

        if (!$quantity)
        {
            $cart = session('cart', []);
            if (array_key_exists($itemGroup->id, $cart))
            {
                $quantity = $cart[$itemGroup->id]['quantity'];
            }

            if ($add)
            {
                ++$quantity;
            }
        }

        return ($itemGroup->totalUserOrders + $quantity) <= $itemGroup->user_purchase_limit;
    }
}
