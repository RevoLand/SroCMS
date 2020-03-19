<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VoteProviderRewardGroupsDataTable;
use App\Http\Controllers\Controller;
use App\VoteProvider;
use App\VoteProviderRewardGroup;
use Illuminate\Http\Request;

class VoteProviderRewardGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VoteProviderRewardGroupsDataTable $dataTable)
    {
        return $dataTable->render('votes.providers.rewardgroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $voteProviders = VoteProvider::enabled()->get();

        return view('votes.providers.rewardgroups.create', compact('voteProviders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateRewardGroup();

        $rewardgroup = VoteProviderRewardGroup::create([
            'name' => request('name'),
            'enabled' => request('enabled'),
        ]);

        $selectedVoteProviders = $rewardgroup->voteproviders()->attach(request('vote_providers'));

        return redirect()->route('admin.votes.providers.rewardgroups.edit', $rewardgroup)->with('message', 'Vote Provider Reward Group is successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id $rewardgroup
     *
     * @return \Illuminate\Http\Response
     */
    public function show(VoteProviderRewardGroup $rewardgroup)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id $rewardgroup
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(VoteProviderRewardGroup $rewardgroup)
    {
        $voteProviders = VoteProvider::enabled()->get();
        $selectedVoteProviders = $rewardgroup->voteproviders->pluck('id')->toArray();

        return view('votes.providers.rewardgroups.edit', compact('rewardgroup', 'voteProviders', 'selectedVoteProviders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id $rewardgroup
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VoteProviderRewardGroup $rewardgroup)
    {
        $this->validateRewardGroup();

        $rewardgroup->update([
            'name' => request('name'),
            'enabled' => request('enabled'),
        ]);

        $rewardgroup->voteproviders()->sync(request('vote_providers'));

        return redirect()->route('admin.votes.providers.rewardgroups.edit', compact('rewardgroup'))->with('message', 'Vote Provider Reward Group is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id $rewardgroup
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(VoteProviderRewardGroup $rewardgroup)
    {
        $rewardgroup->delete();

        return redirect()->route('admin.votes.providers.rewardgroups.index')->with('message', 'Selected reward group has been successfully deleted.');
    }

    public function destroyAjax(VoteProviderRewardGroup $rewardgroup)
    {
        $rewardgroup->delete();

        return response()->json(['message' => 'Selected reward group has been successfully deleted.']);
    }

    public function toggleEnabled(VoteProviderRewardGroup $rewardgroup)
    {
        $rewardgroup->update([
            'enabled' => !$rewardgroup->enabled,
        ]);

        return response()->json(['message' => 'Selected reward group enabled state has been updated.']);
    }

    private function validateRewardGroup()
    {
        return request()->validate([
            'name' => ['required', 'string'],
            'vote_providers' => ['required', 'array', 'exists:App\VoteProvider,id'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
