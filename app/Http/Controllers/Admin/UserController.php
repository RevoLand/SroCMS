<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use stdClass;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load(['loginAttempts', 'characters', 'orders' => function ($query)
        {
            $query->with('items.itemgroup')->latest()->take(40);
        }, 'referrals' => function ($query)
        {
            $query->with('user')->latest()->take(40);
        }, 'voteLogs' => function ($query)
        {
            $query->with(['rewardgroup', 'voteProvider'])->latest()->take(40);
        }, 'articleComments', ]);

        $orderCount = $user->orders()->count();
        $referralCount = $user->referrals()->count();
        $epinCount = $user->epins()->count();

        $voteInfo = new stdClass();
        $voteInfo->completed = $user->voteLogs()->voted()->count();
        $voteInfo->uncompleted = $user->voteLogs()->notVoted()->count();
        $voteInfo->total = $voteInfo->completed + $voteInfo->uncompleted;

        return view('users.show', compact('user', 'orderCount', 'referralCount', 'epinCount', 'voteInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function getUsernames()
    {
        if (!request()->expectsJson())
        {
            return;
        }

        $search = request()->validate([
            'search' => ['string'],
        ])['search'];

        return User::select(['JID as id', 'StrUserID as text'])->where('StrUserID', 'like', "{$search}%")->orWhere('Name', 'like', "{$search}%")->paginate(10);
    }
}
