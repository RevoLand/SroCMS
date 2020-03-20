<?php

namespace App\Http\Controllers;

use App\Character;

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
        $character->load(['guild', 'inventory' => function ($query)
        {
            $query->ignoreDummy()->equipped()->with(['item.objCommon.objItem.setItem', 'item.objCommon.name']);
        }, 'inventoryForAvatar' => function ($query)
        {
            $query->ignoreDummy()->with(['item.objCommon.objItem.setItem', 'item.objCommon.name']);
        }, 'skillMastery' => function ($query)
        {
            $query->minLevel(1)->orderByDesc('Level');
        }, ]);

        return view('user.characters.show', compact('character'));
    }
}
