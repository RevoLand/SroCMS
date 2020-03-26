<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteProviderRewardsDataTable;
use App\Http\Controllers\Controller;
use App\VoteProviderReward;
use App\VoteProviderRewardGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoteProviderRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoteProviderRewardGroup $rewardgroup, VoteProviderRewardsDataTable $dataTable)
    {
        return $dataTable->with('rewardgroupid', $rewardgroup->id)->render('votes.rewards.index', compact('rewardgroup'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(VoteProviderRewardGroup $rewardgroup)
    {
        $rewardgroups = VoteProviderRewardGroup::all();

        return view('votes.rewards.create', compact(['rewardgroup', 'rewardgroups']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateReward();

        $reward = VoteProviderReward::create([
            'vote_provider_reward_group_id' => request('reward_group_id'),
            'type' => request('type'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'balance' => request('balance'),
            'plus' => request('plus'),
            'enabled' => request('enabled'),
        ]);

        return redirect()->route('admin.votes.rewards.create', $reward->vote_provider_reward_group_id)->with('message', 'Reward is successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(VoteProviderReward $reward)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(VoteProviderReward $reward)
    {
        $rewardgroups = VoteProviderRewardGroup::all();

        return view('votes.rewards.edit', compact('reward', 'rewardgroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteProviderReward $reward)
    {
        $this->validateReward();

        $reward->update([
            'vote_provider_reward_group_id' => request('reward_group_id'),
            'type' => request('type'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'balance' => request('balance'),
            'plus' => request('plus'),
            'enabled' => request('enabled'),
        ]);

        return redirect()->route('admin.votes.rewards.edit', $reward)->with('message', 'Reward is successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteProviderReward $reward)
    {
        $reward->delete();

        if (request()->expectsJson())
        {
            return response()->json(['message' => 'Selected reward is successfully deleted.']);
        }

        return redirect()->route('admin.votes.rewards.index', $reward->vote_provider_reward_group_id)->with('message', 'Selected reward is successfully deleted.');
    }

    public function toggleEnabled(VoteProviderReward $reward)
    {
        $reward->update([
            'enabled' => !$reward->enabled,
        ]);

        return response()->json(['message' => 'Enabled status has been updated for selected reward.']);
    }

    private function validateReward()
    {
        return request()->validate([
            'reward_group_id' => ['required', 'integer', 'exists:App\VoteProviderRewardGroup,id'],
            'type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'codename' => ['nullable', 'string', Rule::requiredIf(request('type') == 6)],
            'plus' => ['nullable', 'integer', Rule::requiredIf(request('type') == 6)],
            'balance' => ['nullable', 'numeric', Rule::requiredIf(request('type') < 3)],
            'amount' => ['nullable', 'integer', Rule::requiredIf(request('type') > 2 && request('type') < 6)],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
