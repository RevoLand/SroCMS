<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\ItemMallOrderItem;
use App\User;
use DB;
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
            $query->with(['user' => function ($q)
            {
                $q->select('JID', 'StrUserID', 'Name');
            }, ])->latest()->take(40);
        }, 'voteLogs' => function ($query)
        {
            $query->with(['rewardgroup', 'voteProvider'])->latest()->take(40);
        }, 'articleComments', ]);

        //region Order related informations
        $ordersByItemGroups = ItemMallOrderItem::groupBy('item_mall_item_group_id')->select('item_mall_item_group_id', DB::raw('SUM(quantity) as orders'))->where('user_id', $user->JID)->with(['itemgroup' => function ($query)
        {
            $query->with(['categories' => function ($q)
            {
                $q->select('name');
            }, ])->select(['id', 'name']);
        }, ])->get();

        $ordersDetailedInfo = new stdClass();
        $ordersDetailedInfo->itemgroup_names = $ordersByItemGroups->pluck('itemgroup.name');
        $ordersDetailedInfo->itemgroup_orders = $ordersByItemGroups->pluck('orders');
        $ordersDetailedInfo->categories = $ordersByItemGroups->groupBy(['itemgroup.categories.*.name'])->map(function ($item, $key)
        {
            return [
                'name' => $key,
                'orders' => $item->sum('orders'),
            ];
        });
        $ordersDetailedInfo->category_names = $ordersDetailedInfo->categories->pluck('name');
        $ordersDetailedInfo->category_orders = $ordersDetailedInfo->categories->pluck('orders');
        //endregion

        /*
            PriceHistory::select(DB::raw('count(*) as ChangeCount, Date(created_at) as ChangeDate, NewPrice > OldPrice AS PriceIncreased'))
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->groupBy('ChangeDate', 'PriceIncreased')
            ->orderBy('ChangeDate', 'DESC')
            ->get();
        */
        return view('users.show', compact('user', 'ordersDetailedInfo'));
    }

    public function getCounts(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        return response()->json([
            'orders' => $user->orders()->count(),
            'referrals' => $user->referrals()->count(),
            'epins' => $user->epins()->count(),
            'articlecomments' => $user->articleComments()->count(),
        ]);
    }

    public function getVoteInfo(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $voteInfo = new stdClass();
        $voteInfo->completed = $user->voteLogs()->voted()->count();
        $voteInfo->uncompleted = $user->voteLogs()->notVoted()->count();
        $voteInfo->total = $voteInfo->completed + $voteInfo->uncompleted;

        return response()->json([
            'total' => $voteInfo->total,
            'labels' => ['Completed', 'Uncompleted'],
            'values' => [$voteInfo->completed, $voteInfo->uncompleted],
        ]);
    }

    public function getVoteInfoByRewards(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $votesByRewards = $user->voteLogs()->select('selected_reward_group_id', DB::raw('count(*) as reward_count'))->with(['rewardgroup' => function ($query)
        {
            $query->select('id', 'name');
        }, ])->voted()->groupBy('selected_reward_group_id')->get();

        return response()->json([
            'labels' => $votesByRewards->pluck('rewardgroup.name'),
            'values' => $votesByRewards->pluck('reward_count'),
        ]);
    }

    public function getVoteInfoByProviders(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $votesByProviders = $user->voteLogs()->select('vote_provider_id', DB::raw('count(*) as provider_count'))->with(['voteprovider' => function ($query)
        {
            $query->select('id', 'name');
        }, ])->voted()->groupBy('vote_provider_id')->get();

        return response()->json([
            'labels' => $votesByProviders->pluck('voteprovider.name'),
            'values' => $votesByProviders->pluck('provider_count'),
        ]);
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
