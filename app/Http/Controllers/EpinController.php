<?php

namespace App\Http\Controllers;

use Alert;
use App\Epin;
use Carbon\Carbon;
use Redirect;

class EpinController extends Controller
{
    public function __construct()
    {
        if (!setting('epin.enabled', 1))
        {
            Redirect::route('home')->send();
        }

        $this->middleware('throttle:6,1')->only('use');
    }

    public function index()
    {
        return view('user.epin.index');
    }

    public function use()
    {
        request()->validate([
            'epin' => ['required', 'string', 'exists:App\Epin,code'],
        ]);

        $epin = Epin::where('code', request('epin'))->first();

        if (!$epin->enabled || $epin->used_at)
        {
            Alert::error('Belirtmiş olduğunuz E-Pin kodu kullanılmıştır.');

            return back();
        }

        $epin->update([
            'enabled' => 'false',
            'used_at' => Carbon::now(),
            'user_id' => auth()->user()->JID,
        ]);

        switch ($epin->type)
        {
            case config('constants.payment_types.balance'):
                auth()->user()->balance->increase('balance', $epin->balance, config('constants.balance.source.epin'), 'E-Pin Kodu Kullanıldı. Kod: ' . $epin->code, $epin->creater_user_id);
            break;
            case config('constants.payment_types.balance_point'):
                auth()->user()->balance->increase('balance_point', $epin->balance, config('constants.balance.source.epin'), 'E-Pin Kodu Kullanıldı. Kod: ' . $epin->code, $epin->creater_user_id);
            break;
            case config('constants.payment_types.silk'):
                auth()->user()->silk->increase(config('constants.silk.type.id.silk_own'), intval($epin->balance), config('constants.silk.reason.inc.silk_own'), 'E-Pin Kodu Kullanıldı. Kod: ' . $epin->code);
            break;
            case config('constants.payment_types.silk_gift'):
                auth()->user()->silk->increase(config('constants.silk.type.id.silk_gift'), intval($epin->balance), config('constants.silk.reason.inc.silk_gift'), 'E-Pin Kodu Kullanıldı. Kod: ' . $epin->code);
            break;
            case config('constants.payment_types.silk_point'):
                auth()->user()->silk->increase(config('constants.silk.type.id.silk_point'), intval($epin->balance), config('constants.silk.reason.inc.silk_point'), 'E-Pin Kodu Kullanıldı. Kod: ' . $epin->code);
            break;
            case config('constants.payment_types.item'):
                if (!$epin->items)
                {
                    Alert::error('There are no items defined for this e-pin code, please contact with the administrator.');

                    return back();
                }

                foreach ($epin->items as $item)
                {
                    $maxStack = $item->objCommon->objItem->MaxStack;
                    $amountToGive = $item->amount;

                    while ($amountToGive > 0)
                    {
                        auth()->user()->addChestItem($item->codename, ($maxStack % $amountToGive === $maxStack) ? $maxStack : $amountToGive, $item->plus);

                        $amountToGive -= $maxStack;
                    }
                }
            break;
        }

        // TODO: Daha fazla & detaylı bilgi.
        Alert::success('E-Pin code is successfully used on the account.');

        return redirect()->route('epin.index');
    }
}
