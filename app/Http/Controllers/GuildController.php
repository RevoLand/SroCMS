<?php

namespace App\Http\Controllers;

use App\Guild;

class GuildController extends Controller
{
    public function __construct()
    {
        if (setting('users.show_guild_requires_auth', 0))
        {
            $this->middleware('auth');
        }
    }

    public function show(Guild $guild)
    {
        $guild->load(['siegeFortress', 'members' => function ($query)
            {
                $query->orderBy('MemberClass', 'asc')
                    ->orderBy('SiegeAuthority', 'asc')
                    ->orderBy('Permission', 'desc')
                    ->orderBy('GP_Donation', 'desc')
                    ->orderBy('CharLevel', 'desc');
            }, ]);

        return view('user.guilds.show', compact('guild'));
    }
}
