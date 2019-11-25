<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');

        if (setting('users.show_character_requires_auth', 0))
        {
            $this->middleware('auth');
        }
    }

    public function index(Request $request)
    {
        // TODO: Mevcut hesabın karakterleri listelenecek.
        return 'Not implemented.';
    }

    public function show(Character $character)
    {
        $characterInventory = DB::connection('shard')
            ->table('_Inventory')
            ->join('_Items', '_Inventory.ItemID', '=', '_Items.ID64')
            ->join('_RefObjCommon', '_Items.RefItemID', '=', '_RefObjCommon.ID')
            ->select('_Inventory.*', '_Items.*', '_RefObjCommon.*')
            ->where('CharID', $character->CharID)
            ->get();

        return view('user.characters.show', compact(['character', 'characterInventory']));
    }
}
