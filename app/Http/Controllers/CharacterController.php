<?php

namespace App\Http\Controllers;

use App\Character;
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

    public function index()
    {
        // TODO: Mevcut hesabın karakterleri listelenecek.
        return 'Not implemented.';
    }

    public function show(Character $character)
    {
        // Karakter envanteri, envanterde bulunan itemlerin _Items tablosu ve _RefObjCommon tablosu verileri ile birlikte.
        $characterInventory = DB::connection('shard')
            ->table('_Inventory')
            ->join('_Items', '_Inventory.ItemID', '=', '_Items.ID64')
            ->join('_RefObjCommon', '_Items.RefItemID', '=', '_RefObjCommon.ID')
            ->select('_Inventory.*', '_Items.*', '_RefObjCommon.*')
            ->where('CharID', $character->CharID)
            ->get();

        // Karakter skill mastery bilgisi, mastery'e ait bilgiler ile birlikte.
        $characterMastery = $character->skillMastery()
            ->join('_RefSkillMastery', 'MasteryID', '=', '_RefSkillMastery.ID')
            ->where('Level', '!=', 0)
            ->orderByDesc('Level')
            ->get();

        return view('user.characters.show', compact(['character', 'characterInventory', 'characterMastery']));
    }
}
