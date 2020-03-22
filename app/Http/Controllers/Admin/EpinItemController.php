<?php

namespace App\Http\Controllers\Admin;

use App\EpinItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EpinItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $epinItem = EpinItem::create([
            'epin_id' => request('epin_id'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'plus' => request('plus'),
        ]);

        return response()->json(['epinItem' => $epinItem, 'message' => 'Item is successfully created.']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        request()->validate([
            'id' => ['sometimes', 'integer', 'exists:App\EpinItem'],
            'epin_id' => ['required', 'integer', 'exists:App\Epin,id'],
            'codename' => ['required', 'string'],
            'amount' => ['required', 'integer', 'min:1'],
            'plus' => ['required', 'integer', 'min:0'],
        ]);

        if (!request()->filled('id'))
        {
            return $this->store();
        }

        $epinitem = EpinItem::find(request('id'));

        $epinitem->update([
            'epin_id' => request('epin_id'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'plus' => request('plus'),
        ]);

        return response()->json(['item' => $epinitem, 'message' => 'Item is successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\EpinItem'],
        ]);

        EpinItem::find(request('id'))->delete();

        return response()->json(['message' => 'Selected Item is successfully removed.']);
    }
}
