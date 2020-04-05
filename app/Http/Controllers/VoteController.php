<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteCallbackRequest;
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

    public function callback(VoteCallbackRequest $request)
    {
        if (setting('votes.callback_ip_check', 1))
        {
            if (VoteProviderIp::where('ip', $request->getClientIp())->count() == 0)
            {
                return response()->json([
                    'message' => 'Unauthorized action.',
                ], 401);
            }
        }

        $voteLog = VoteLog::where('secret', $request->input($request->voteProvider->callback_user_name))->first();

        if (!$voteLog)
        {
            return response()->json([
                'message' => 'Invalid request.',
            ], 403);
        }

        if (!$voteLog->voteProvider->is($request->voteProvider))
        {
            return response()->json([
                'message' => 'This vote log doesn\'t belongs to your service.',
            ], 403);
        }

        return $this->rewardVote($voteLog, "[SroCMS] {$request->voteProvider->name} üzerinden yapılan oylama ödülü.");
    }

    public function index()
    {
        return view('user.votes.index', ['voteProviders' => VoteProvider::enabled()->with(['rewardGroups' => function ($query)
        {
            $query->enabled();
        }, ])->whereHas('rewardGroups.rewards', function ($query)
        {
            $query->enabled();
        })->get()]);
    }

    public function vote(VoteProvider $voteProvider)
    {
        request()->validate([
            'reward' => ['required', 'integer', 'exists:App\VoteProviderRewardGroup,id'],
        ]);

        // Yukarıda gönderilen ödülün varlığını kontrol ederken, burada o ödülün seçilen vote'a bağlı olup olmadığını kontrol ediyoruz.
        if ($voteProvider->rewardGroups()->enabled()->where('vote_provider_reward_group_id', request('reward'))->count() == 0)
        {
            alert('Hata!', 'Geçersiz bir ödül seçimi yaptınız.', 'error');

            return redirect()->route('votes.show_votes');
        }

        if (!$voteProvider->canUserVote())
        {
            // alternatif olarak hata ile vote sayfasına yönlendirilebilir.
            abort(403, 'Şuanda oy kullanamazsınız.');
        }

        $userLastVoteLog = $voteProvider->lastActiveVoteLogForUser(Auth::user()->JID);

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

        $userVoteLog = Auth::user()->voteLogs()->create([
            'secret' => $this->generateVoteLogSecret(),
            'vote_provider_id' => $voteProvider->id,
            'selected_reward_group_id' => request('reward'),
            'user_ip' => request()->getClientIp(),
        ]);

        return redirect($voteProvider->getVoteUrl($userVoteLog));
    }

    public function rewardVote(VoteLog $votelog, string $reason = '')
    {
        if ($votelog->voted)
        {
            return response()->json([
                'message' => 'User already rewarded for this vote call.',
            ], 403);
        }

        if (!$votelog->active)
        {
            return response()->json([
                'message' => 'User can not be rewarded for this call.',
            ], 403);
        }

        $votelog->update([
            'voted' => true,
            'active' => false,
            'callback_ip' => request()->getClientIp(),
        ]);

        $votelog->load(['rewardGroup.rewards' => function ($query)
        {
            $query->enabled();
        }, 'user', ]);

        foreach ($votelog->rewardGroup->rewards as $reward)
        {
            switch ($reward->type)
            {
                // Balance
                case config('constants.payment_types.balance'):
                    $votelog->user->balance->increase(config('constants.balance.type.balance'), $reward->balance, config('constants.balance.source.vote'));
                break;
                // Balance Point
                case config('constants.payment_types.balance_point'):
                    $votelog->user->balance->increase(config('constants.balance.type.point'), $reward->balance, config('constants.balance.source.vote'));
                break;
                // Silk
                case config('constants.payment_types.silk'):
                    $votelog->user->silk->increase(config('constants.silk.type.id.silk_own'), $reward->amount, config('constants.silk.reason.inc.silk_own'), $reason);
                break;
                // Gift Silk
                case config('constants.payment_types.silk_gift'):
                    $votelog->user->silk->increase(config('constants.silk.type.id.silk_gift'), $reward->amount, config('constants.silk.reason.inc.silk_gift'), $reason);
                break;
                // Point Silk
                case config('constants.payment_types.silk_point'):
                    $votelog->user->silk->increase(config('constants.silk.type.id.silk_point'), $reward->amount, config('constants.silk.reason.inc.silk_point'), $reason);
                break;
                // Item
                case config('constants.payment_types.item'):
                    $votelog->user->addChestItem($reward->codename, $reward->amount, $reward->plus);
                break;
            }
        }

        return response()->json([
            'message' => 'User successfully rewarded for the vote.',
        ]);
    }

    private function generateVoteLogSecret($length = 40)
    {
        $randomString = Str::random($length);

        return VoteLog::where('secret', $randomString)->count() > 0 ? $this->generateVoteLogSecret() : $randomString;
    }
}
