<?php

namespace App\Http\Controllers\Admin;

use App\BlockedUser;
use App\DataTables\UserBansDataTable;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlockedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserBansDataTable $dataTable)
    {
        return $dataTable->render('users.bans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->validate([
            'user' => ['sometimes', 'integer', 'exists:App\User,JID'],
        ]);

        if (request()->filled('user'))
        {
            $user = User::find(request('user'));
            $user->load('activeUserBlocks');
        }

        return view('users.bans.create', [
            'user' => $user ?? '',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'user' => ['required', 'integer', 'exists:App\User,JID'],
            'type' => ['required', 'integer', Rule::in(config('constants.punishment_array'))],
            'timeBegin' => ['required', 'date'],
            'timeEnd' => ['required', 'date', 'after:timeBegin'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = User::find($validated['user']);

        $userBlocks = $user->userBlocks()->Type(request('type'))->get();

        foreach ($userBlocks as $activeBlock)
        {
            $activeBlock->punishment()->delete();
            $activeBlock->delete();
        }

        $punishment = $user->punishments()->create([
            'Type' => request('type'),
            'Executor' => auth()->user()->JID,
            'Shard' => setting('server.shard', 3),
            'Description' => request('reason', ''),
            'RaiseTime' => now(),
            'PunishTime' => now(),
            'BlockStartTime' => Carbon::parse(request('timeBegin')),
            'BlockEndTime' => Carbon::parse(request('timeEnd')),
            'Status' => '0',
            'CharName' => '',
            'CharInfo' => '',
            'PosInfo' => '',
            'Guide' => '',
        ]);

        $block = $punishment->blockeduser()->create([
            'UserJID' => $user->JID,
            'UserID' => $user->StrUserID,
            'Type' => request('type'),
            'timeBegin' => Carbon::parse(request('timeBegin')),
            'timeEnd' => Carbon::parse(request('timeEnd')),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'User has been successfully banned.',
            'icon' => 'success',
            'new_block' => $block,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(BlockedUser $ban)
    {
        $ban->load([
            'user' => function ($user)
            {
                $user->with(['activeUserBlocks']);
            },
            'punishment',
        ]);

        return view('users.bans.show', compact('ban'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(BlockedUser $ban)
    {
        $ban->load([
            'user' => function ($user)
            {
                $user->with(['activeUserBlocks']);
            },
            'punishment',
        ]);

        return view('users.bans.edit', compact('ban'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlockedUser $ban)
    {
        $validated = request()->validate([
            'type' => ['required', 'integer', Rule::in(config('constants.punishment_array'))],
            'timeBegin' => ['required', 'date'],
            'timeEnd' => ['required', 'date', 'after:timeBegin'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($ban->Type != $validated['type'])
        {
            $activeBlocks = $ban->user->userBlocks()->Type($validated['type'])->get();

            foreach ($activeBlocks as $activeBlock)
            {
                $activeBlock->punishment()->delete();
                $activeBlock->delete();
            }
        }

        $ban->update([
            'Type' => $validated['type'],
            'timeBegin' => Carbon::parse($validated['timeBegin']),
            'timeEnd' => Carbon::parse($validated['timeEnd']),
        ]);

        $ban->punishment()->update([
            'Type' => $validated['type'],
            'Executor' => auth()->user()->JID,
            'BlockStartTime' => Carbon::parse($validated['timeBegin']),
            'BlockEndTime' => Carbon::parse($validated['timeEnd']),
            'Description' => request('reason', ''),
            'PunishTime' => now(),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'User Ban has been successfully updated.',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlockedUser $ban)
    {
        $ban->delete();

        return response()->json([
            'title' => 'Success!',
            'message' => 'Ban has been successfully deleted!',
            'icon' => 'success',
        ]);
    }
}
