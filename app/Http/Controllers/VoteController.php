<?php

namespace App\Http\Controllers;

use App\VoteLog;
use App\VoteProvider;
use App\VoteProviderIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('callback');

        if (setting('votes.email_must_be_verified', 0))
        {
            $this->middleware('verified')->except('callback');
        }
    }

    public function callback(Request $request, $voteprovider_secret)
    {
        $voteProvider = VoteProvider::where('callback_secret', $voteprovider_secret)->firstOrFail();

        $request->validate([
            $voteProvider->callback_user_name => ['required', 'string', 'max:255'],
            $voteProvider->callback_success_name => ['required', 'string', 'max:255'],
        ]);

        if (VoteProviderIp::where('ip', $request->getClientIp())->count() == 0)
        {
            abort(403, 'Unauthorized action.');
        }

        $voteLog = VoteLog::findOrFail($request->input($voteProvider->callback_user_name));

        if ($voteLog->voted)
        {
            abort(403, 'User already rewarded for this vote call.');
        }

        $voteLog->voted = true;
        $voteLog->save();

        foreach ($voteLog->rewardGroup->rewards as $reward)
        {
            switch ($reward->type)
            {
                // Silk
                case 1:

                break;
                // Gift Silk
                case 2:

                break;
                // Point Silk
                case 3:

                break;
                // Item
                case 4:

                break;
            }
        }
    }

    public function index()
    {
        $voteProviders = VoteProvider::where('enabled', true)->get();

        return view('user.votes.index', compact('voteProviders'));
    }

    /*
    Mevcut mantıkta vote tamamlanmadığı sürece yeni vote çağrılabiliyor ama eski log'u (ve seçilen ödülü kullanıyor)
    Ya yeni vote çağrımını iptal edicez ya da yeni vote + yeni log yapıp aktif & tamamlanmamış log varsa onu kapatıcaz.
    */
    public function vote(VoteProvider $voteProvider, Request $request)
    {
        $request->validate([
            'reward' => ['required', 'string', 'max:255'],
        ]);

        if ($voteProvider->rewardGroups->where('id', $request->reward)->count() == 0)
        {
            alert('Hata!', 'Geçersiz bir ödül seçimi yaptınız.', 'error');

            return redirect()->route('votes.show_votes');
        }

        if (!$voteProvider->canUserVote())
        {
            abort(403, 'Oy kullanabilmek için çok küçüksün.');
        }

        $userLastVoteLog = Auth::user()->lastVoteLog($voteProvider->id);

        if (!$userLastVoteLog->voted)
        {
            dd($voteProvider->getVoteUrl($userLastVoteLog->id));

            return redirect($voteProvider->getVoteUrl($userLastVoteLog->id));
        }

        $userVoteLog = new VoteLog();
        $userVoteLog->user_id = Auth::user()->JID;
        $userVoteLog->vote_provider_id = $voteProvider->id;
        $userVoteLog->selected_reward_group_id = $request->reward;
        if ($userVoteLog->save())
        {
            dd($voteProvider->getVoteUrl($userVoteLog->id));

            return redirect($voteProvider->getVoteUrl($userVoteLog->id));
        }
        abort(500, 'İşlem sırasında bir hata ile karşılaşıldı.');
    }
}
