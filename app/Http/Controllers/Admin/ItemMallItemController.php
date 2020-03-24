<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ItemMallItem;
use Illuminate\Validation\Rule;

class ItemMallItemController extends Controller
{
    public function update()
    {
        request()->validate([
            'id' => ['sometimes', 'integer', 'exists:App\ItemMallItem'],
            'item_mall_item_group_id' => ['required', 'integer', 'exists:App\ItemMallItemGroup,id'],
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'codename' => ['nullable', 'string', Rule::requiredIf(request('type') == 6)],
            'plus' => ['nullable', 'integer', Rule::requiredIf(request('type') == 6)],
            'balance' => ['nullable', 'numeric', Rule::requiredIf(request('type') < 3)],
            'amount' => ['nullable', 'integer', Rule::requiredIf(request('type') > 2 && request('type') < 6)],
            'enabled' => ['required', 'boolean'],
        ]);

        if (!request()->filled('id'))
        {
            return $this->store();
        }

        $item = ItemMallItem::find(request('id'));

        $item->update([
            'item_mall_item_group_id' => request('item_mall_item_group_id'),
            'name' => request('name'),
            'description' => request('description'),
            'image' => request('image'),
            'type' => request('type'),
            'codename' => request('codename'),
            'plus' => request('plus'),
            'balance' => request('balance'),
            'amount' => request('amount'),
            'enabled' => request('enabled'),
        ]);

        return response()->json(['message' => 'Item is successfully updated.']);
    }

    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\ItemMallItem'],
        ]);

        ItemMallItem::find(request('id'))->delete();

        return response()->json(['message' => 'Selected Item is successfully removed.']);
    }

    private function store()
    {
        $item = ItemMallItem::create([
            'item_mall_item_group_id' => request('item_mall_item_group_id'),
            'name' => request('name'),
            'description' => request('description'),
            'image' => request('image'),
            'type' => request('type'),
            'codename' => request('codename'),
            'plus' => request('plus'),
            'balance' => request('balance'),
            'amount' => request('amount'),
            'enabled' => request('enabled'),
        ]);

        return response()->json(['item' => $item, 'message' => 'Item is successfully created.']);
    }
}
