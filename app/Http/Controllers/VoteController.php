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

        if ($voteLog->voted)
        {
            return response()->json([
                'message' => 'User already rewarded for this vote call.',
            ], 403);
        }

        if (!$voteLog->active)
        {
            return response()->json([
                'message' => 'User can not be rewarded for this call.',
            ], 403);
        }

        $voteLog->update([
            'voted' => true,
            'active' => false,
            'callback_ip' => $request->getClientIp(),
        ]);

        foreach ($voteLog->rewardGroup->rewards()->enabled() as $reward)
        {
            switch ($reward->type)
            {
                // Balance
                case config('constants.payment_types.balance'):
                    $voteLog->user->balance->increase(config('constants.balance.type.balance'), $reward->balance, config('constants.balance.source.vote'));
                break;
                // Balance Point
                case config('constants.payment_types.balance_point'):
                    $voteLog->user->balance->increase(config('constants.balance.type.point'), $reward->balance, config('constants.balance.source.vote'));
                break;
                // Silk
                case config('constants.payment_types.silk'):
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_own'), $reward->amount, config('constants.silk.reason.inc.silk_own'), "[SroCMS] {$request->voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Gift Silk
                case config('constants.payment_types.silk_gift'):
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_gift'), $reward->amount, config('constants.silk.reason.inc.silk_gift'), "[SroCMS] {$request->voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Point Silk
                case config('constants.payment_types.silk_point'):
                    $voteLog->user->silk->increase(config('constants.silk.type.id.silk_point'), $reward->amount, config('constants.silk.reason.inc.silk_point'), "[SroCMS] {$request->voteProvider->name} üzerinden yapılan oylama ödülü.");
                break;
                // Item
                case config('constants.payment_types.item'):
                    $voteLog->user->addChestItem($reward->codename, $reward->amount, $reward->plus);
                break;
            }
        }

        return response()->json([
            'message' => 'User successfully rewarded for the vote.',
        ], 200);
    }

    public function index()
    {
        return view('user.votes.index', ['voteProviders' => VoteProvider::enabled()->with(['rewardGroups' => function ($query)
        {
            $query->enabled();
        }, ])->get()]);
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

    private function generateVoteLogSecret($length = 40)
    {
        $randomString = Str::random($length);

        return VoteLog::where('secret', $randomString)->count() > 0 ? $this->generateVoteLogSecret() : $randomString;
    }
}
