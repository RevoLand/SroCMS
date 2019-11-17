<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Request $request)
    {
        // TODO: Karakterler listelenecek.
        return 'Not implemented.';
    }

    public function show(Character $character)
    {
        dd($character);
    }
}
