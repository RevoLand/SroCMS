<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;

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
        return view('user.characters.show', compact('character'));
    }
}
