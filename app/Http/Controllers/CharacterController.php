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
        $character->load('guild', 'inventory.item.objCommon', 'skillMastery', 'logEventChar');

        return view('user.characters.show', compact('character'));
    }
}
