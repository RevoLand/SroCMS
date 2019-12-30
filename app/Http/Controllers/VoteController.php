<?php

namespace App\Http\Controllers;

use App\VoteLog;
use App\VoteProvider;
use App\VoteProviderIp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function callback($voteprovider_secret)
    {
        $voteProvider = VoteProvider::where('callback_secret', $voteprovider_secret)->firstOrFail();

        request()->validate([
            $voteProvider->callback_user_name => ['required', 'string', 'max:255'],
            $voteProvider->callback_success_name => ['required', 'string', 'max:255'],
        ]);

        if (setting('votes.callback_ip_check', 1))
        {
            if (VoteProviderIp::where('ip', request()->getClientIp())->count() == 0)
            {
                abort(403, 'Unauthorized action.');
            }
        }

        $voteLog = VoteLog::where('secret', request()->input($voteProvider->callback_user_name))->firstOrFail();

        if ($voteLog->voted)
        {
            abort(403, 'User already rewarded for this vote call.');
        }

        if (!$voteLog->active)
        {
            abort(403, 'User can not be rewarded for this call.');
        }

        $voteLog->voted = true;
        $voteLog->active = false;
        $voteLog->save();

        foreach ($voteLog->rewardGroup->rewards as $reward)
        {
            // TODO: Vote sistemi ödüllerinin verilmesi.
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

    public function vote(VoteProvider $voteProvider)
    {
        request()->validate([
            'reward' => ['required', 'integer', 'exists:App\VoteProviderReward,id'],
        ]);

        // Burası olduğu için yukarıdaki doğrulama kurallarındaki exists kullanılmasa da olur.
        if ($voteProvider->rewardGroups->where('id', request('reward'))->count() == 0)
        {
            alert('Hata!', 'Geçersiz bir ödül seçimi yaptınız.', 'error');

            return redirect()->route('votes.show_votes');
        }

        if (!$voteProvider->canUserVote())
        {
            // hata ile vote sayfasına yönlendirilebilir.
            abort(403, 'Şuanda oy kullanamazsınız.');
        }

        $userLastVoteLog = $voteProvider->lastActiveVoteLog(Auth::user()->id);

        if ($userLastVoteLog)
        {
            if (!$userLastVoteLog->voted && $userLastVoteLog->selected_reward_group_id == request('reward'))
            {
                return redirect($voteProvider->getVoteUrl($userLastVoteLog));
            }

            if ($userLastVoteLog->active)
            {
                $userLastVoteLog->active = false;
                $userLastVoteLog->save();
            }
        }

        $userVoteLog = new VoteLog();
        $userVoteLog->secret = $this->generateVoteLogSecret();
        $userVoteLog->user_id = Auth::user()->JID;
        $userVoteLog->vote_provider_id = $voteProvider->id;
        $userVoteLog->selected_reward_group_id = request('reward');

        if ($userVoteLog->save())
        {
            return redirect($voteProvider->getVoteUrl($userVoteLog));
        }

        abort(500, 'İşlem sırasında bir hata ile karşılaşıldı.');
    }

    private function generateVoteLogSecret($length = 40)
    {
        $randomString = Str::random($length);

        return VoteLog::where('secret', $randomString)->count() > 0 ? $this->generateVoteLogSecret() : $randomString;
    }
}
