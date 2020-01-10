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

        $voteLog->update([
            'voted' => true,
            'active' => false,
        ]);

        foreach ($voteLog->rewardGroup->rewards as $reward)
        {
            switch ($reward->type)
            {
                /*
                    //-- Sadece Görsel, işlem silk_type üzerinden yapılıyor --\\

                    reason
                        0	= silk_own add
                        1	= silk_own remove
                        2	= Job Points add
                        3	= (You have SENT [x] Coin as gift) (remove)
                        4 	= Points add
                        5	= (You have USED [x] points) (remove)
                */
                // Silk
                case 1:
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_own'), $reward->amount, config('constants.silk.reason.inc.silk_own'), "[SroCMS] {$voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Gift Silk
                case 2:
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_gift'), $reward->amount, config('constants.silk.reason.inc.silk_gift'), "[SroCMS] {$voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Point Silk
                case 3:
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_point'), $reward->amount, config('constants.silk.reason.inc.silk_point'), "[SroCMS] {$voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Item
                case 4:
                    $voteLog->user->addChestItem($reward->codename, $reward->amount, $reward->plus);
                break;
            }
        }

        echo 'OK';
    }

    public function index()
    {
        return view('user.votes.index', ['voteProviders' => VoteProvider::where('enabled', true)->with(['rewardGroups'])->get()]);
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
            // alternatif olarak hata ile vote sayfasına yönlendirilebilir.
            abort(403, 'Şuanda oy kullanamazsınız.');
        }

        $userLastVoteLog = $voteProvider->lastActiveVoteLog(Auth::user()->JID);

        if ($userLastVoteLog)
        {
            if (!$userLastVoteLog->voted && $userLastVoteLog->selected_reward_group_id == request('reward'))
            {
                return redirect($voteProvider->getVoteUrl($userLastVoteLog));
            }

            if ($userLastVoteLog->active)
            {
                $userLastVoteLog->update(['active' => false]);
            }
        }

        $userVoteLog = VoteLog::create([
            'secret' => $this->generateVoteLogSecret(),
            'user_id' => Auth::user()->JID,
            'vote_provider_id' => $voteProvider->id,
            'selected_reward_group_id' => request('reward'),
        ]);

        return redirect($voteProvider->getVoteUrl($userVoteLog));
    }

    private function generateVoteLogSecret($length = 40)
    {
        $randomString = Str::random($length);

        return VoteLog::where('secret', $randomString)->count() > 0 ? $this->generateVoteLogSecret() : $randomString;
    }
}
