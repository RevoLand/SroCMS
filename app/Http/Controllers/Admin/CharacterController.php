<?php

namespace App\Http\Controllers\Admin;

use App\Character;
use App\Http\Controllers\Controller;

class CharacterController extends Controller
{
    public function show(Character $character)
    {
        ddd($character);
    }

    public function getPosition()
    {
        request()->validate([
            'character' => ['required', 'string', 'exists:App\Character,CharName16'],
        ]);

        $character = Character::firstWhere('CharName16', request('character'));

        return response()->json([
            'characterid' => $character->CharID,
            'RegionId' => $character->LatestRegion,
            'PosX' => $character->PosX,
            'PosY' => $character->PosY,
            'PosZ' => $character->PosZ,
            'WorldId' => $character->WorldID,
            'title' => 'Updated!',
            'message' => 'Character position is successfully retrieved.',
            'icon' => 'success',
        ]);
    }
}
