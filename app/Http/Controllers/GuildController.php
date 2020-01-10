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
        $guild->load(['siegeFortress', 'members']);

        $sortedGuildMembers = $guild->members->sortBy(function ($guildf)
        {
            return [
                $guildf->MemberClass,
                -$guildf->GP_Donation,
                -$guildf->Level,
            ];
        });

        return view('user.guilds.show', compact('guild', 'sortedGuildMembers'));
    }
}
