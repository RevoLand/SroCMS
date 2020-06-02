<?php

namespace App\Http\Controllers\Admin;

use App\Character;
use App\Http\Controllers\Controller;
use App\ObjCommon;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    const SELECTOR_TARGET_CHARACTER = 1;
    const SELECTOR_TARGET_USER = 2;

    const ITEM_TARGET_CHARACTER = 1;
    const ITEM_TARGET_USER = 2;

    public function giveItemForm()
    {
        return view('items.give_item');
    }

    public function giveItem()
    {
        request()->validate([
            'type' => ['required', 'integer', Rule::in([1, 2])],
            'target' => ['required', 'integer', Rule::in([1, 2])],
            'character' => ['nullable', 'integer', 'exists:App\Character,CharID'],
            'account' => ['nullable', 'integer', 'exists:App\User,JID'],
            'codename' => ['required', 'string', 'exists:App\ObjCommon,CodeName128'],
            'quantity' => ['required', 'integer', 'min:1', 'max:50000'],
            'optlevel' => ['required', 'integer', 'min:0', 'max:32'],
        ]);

        $item = ObjCommon::where('CodeName128', request('codename'))->with('objItem')->firstOrFail();
        $quantity = request('quantity');
        $optlevel = request('optlevel');
        $maxStack = $item->objItem->MaxStack;
        $itemToGive = ($maxStack % $quantity == $maxStack) ? $maxStack : $quantity;

        if (request('type') == self::SELECTOR_TARGET_USER)
        { // Account
            $user = User::find(request('account'));
            if (!$user)
            {
                return response()->json([
                    'title' => 'Error!',
                    'message' => 'You must select an account!',
                    'icon' => 'error',
                ], 400);
            }

            while ($quantity > 0)
            {
                $user->addChestItem($item->CodeName128, $itemToGive, $optlevel);

                $quantity -= $maxStack;
            }

            return response()->json([
                'title' => 'Success!',
                'message' => 'Item given to the selected account.',
                'icon' => 'success',
            ]);
        }

        if (request('type') == self::SELECTOR_TARGET_CHARACTER)
        {
            $character = Character::find(request('character'));
            if (!$character)
            {
                return response()->json([
                    'title' => 'Error!',
                    'message' => 'You must select a character!',
                    'icon' => 'error',
                ], 400);
            }

            while ($quantity > 0)
            {
                if (request('target') == self::ITEM_TARGET_CHARACTER)
                {
                    $character->addItem($item->CodeName128, $itemToGive, $optlevel);
                }
                elseif (request('target') == self::ITEM_TARGET_USER)
                {
                    $character->user->account->addChestItem($item->CodeName128, $itemToGive, $optlevel);
                }

                $quantity -= $maxStack;
            }

            return response()->json([
                'title' => 'Success!',
                'message' => 'Item given to the selected character.',
                'icon' => 'success',
            ]);
        }
    }

    public function getEnabledItems()
    {
        if (!request()->expectsJson())
        {
            return;
        }

        $search = request()->validate(['search' => 'string|max:100'])['search'];

        $paginator = ObjCommon::item()->ignoreDummy()->enabled()->oldest('ID')
            ->select(['ID', 'CodeName128', 'NameStrID128', 'Link'])
            ->where('ID', 'like', $search)
            ->orWhere('CodeName128', 'like', "%{$search}%")
            ->with(['name', 'objItem:ID,MaxStack'])
            // ->orWhereHas('name', function (Builder $query) use ($search)
            // {
            //     $query->where('name', 'like', "%{$search}%");
            // })
            ->paginate(30);

        $newColleciton = $paginator->getCollection()
            ->map(function (ObjCommon $objCommon)
            {
                return [
                    'id' => $objCommon->CodeName128,
                    'text' => "[{$objCommon->ID}] {$objCommon->getName()} | {$objCommon->CodeName128} | MaxStack: {$objCommon->objItem->MaxStack}",
                ];
            });

        $paginator->setCollection($newColleciton);

        return $paginator;
    }
}
