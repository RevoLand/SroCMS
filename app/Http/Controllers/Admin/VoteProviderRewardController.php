<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\VoteProviderReward;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VoteProviderRewardController extends Controller
{
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
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validateReward();

        $reward = VoteProviderReward::find(request('id'));

        if (!$reward)
        {
            return $this->store();
        }

        $reward->update([
            'type' => request('type'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'balance' => request('balance'),
            'plus' => request('plus'),
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Reward is successfully updated!',
            'type' => 'success',
            'type_name' => $reward->type_name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        request()->validate([
            'id' => ['required', 'integer', 'exists:App\VoteProviderReward'],
        ]);

        VoteProviderReward::find(request('id'))->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Reward is successfully deleted.',
            'type' => 'success',
        ]);
    }

    public function toggleEnabled(VoteProviderReward $reward)
    {
        $reward->update([
            'enabled' => !$reward->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Enabled status has been updated for selected reward.',
            'type' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    private function store()
    {
        $reward = VoteProviderReward::create([
            'vote_provider_reward_group_id' => request('vote_provider_reward_group_id'),
            'type' => request('type'),
            'codename' => request('codename'),
            'amount' => request('amount'),
            'balance' => request('balance'),
            'plus' => request('plus'),
            'enabled' => request('enabled'),
        ]);

        return response()->json([
            'title' => 'Created!',
            'message' => 'Reward is successfully created.',
            'type' => 'success',
            'reward' => $reward,
        ]);
    }

    private function validateReward()
    {
        return request()->validate([
            'vote_provider_reward_group_id' => ['required', 'integer', 'exists:App\VoteProviderRewardGroup,id'],
            'type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'codename' => ['nullable', 'string', Rule::requiredIf(request('type') == 6)],
            'plus' => ['nullable', 'integer', Rule::requiredIf(request('type') == 6)],
            'balance' => ['nullable', 'numeric', Rule::requiredIf(request('type') < 3)],
            'amount' => ['nullable', 'integer', Rule::requiredIf(request('type') > 2 && request('type') < 6)],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
