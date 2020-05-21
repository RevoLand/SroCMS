<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\ItemMallOrderItem;
use App\Notifications\EmailChangedToNew;
use App\Notifications\EmailChangedToOld;
use App\Notifications\PasswordChange;
use App\ShardCharNames;
use App\User;
use Auth;
use DB;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use stdClass;
use Str;

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
            $query->with(['user' => function ($query)
            {
                $query->select('JID', 'StrUserID', 'Name');
            }, ])->latest()->take(40);
        }, 'voteLogs' => function ($query)
        {
            $query->with(['rewardgroup', 'voteProvider'])->latest()->take(40);
        }, 'articleComments', ]);

        //region Order related informations
        $ordersByItemGroups = ItemMallOrderItem::groupBy('item_mall_item_group_id')->select('item_mall_item_group_id')->selectRaw('SUM(quantity) as orders')->where('user_id', $user->JID)->with(['itemgroup' => function ($query)
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
            'tickets' => $user->tickets()->count(),
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

        $votesByRewards = $user->voteLogs()->select('selected_reward_group_id')->selectRaw('count(*) as reward_count')->with(['rewardgroup' => function ($query)
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

    public function getActiveBlocks(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $user->load('activeUserBlocks');

        return response()->json([
            'active_blocks' => $user->activeUserBlocks,
        ]);
    }

    public function getUserInfo(User $user)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $user->load([
            'balance',
            'silk',
            'characters',
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user = null)
    {
        if (isset($user))
        {
            $user->load([
                'balance',
                'silk',
                'characters',
            ]);
        }

        return view('users.edit', [
            'user' => $user ?? '',
        ]);
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

    public function updateInformation(User $user)
    {
        request()->validate([
            'name' => ['nullable', 'string', 'max:50'],
            'regtime' => ['nullable', 'date'],
            'reg_ip' => ['nullable', 'ip'],
        ]);

        $user->update([
            'Name' => request('name'),
            'regtime' => request('regtime'),
            'reg_ip' => request('reg_ip'),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Changes has been successfully saved.',
            'icon' => 'success',
        ]);
    }

    public function updatePassword(User $user)
    {
        request()->validate([
            'auto_generate' => ['required', 'boolean'],
            'inform_mail_user' => ['required', 'boolean'],
            'new_password' => ['nullable', 'required_if:auto_generate,0', 'confirmed'],
        ]);

        if ($user->hasRole('Super Admin') && !auth()->user()->hasRole('Super Admin'))
        {
            return response()->json([
                'title' => 'ERROR!',
                'message' => 'You don\'t have permission for this action.',
                'icon' => 'error',
            ]);
        }

        $newPassword = request('auto_generate') ? Str::random(16) : request('new_password');

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        if (request('inform_mail_user'))
        {
            $user->notify(new PasswordChange($newPassword));
        }

        return response()->json([
            'title' => 'Success!',
            'message' => "User's password has been successfully changed.<br/><br/>New Password:<br/><input type='text' value='{$newPassword}' class='form-control bg-200' readonly />",
            'icon' => 'success',
        ]);
    }

    public function updateEmail(User $user)
    {
        request()->validate([
            'reset_email_verification_state' => ['required', 'boolean'],
            'inform_old_email' => ['required', 'boolean'],
            'inform_new_email' => ['required', 'boolean'],
            'new_email' => ['required', 'email', 'confirmed'],
        ]);

        if (request('inform_old_email'))
        {
            $user->notify(new EmailChangedToOld(request('new_email'), $user->StrUserID));
        }

        $oldEmail = $user->Email;

        $user->update([
            'Email' => request('new_email'),
            'email_verified_at' => request('reset_email_verification_state') ? null : $user->email_verified_at,
        ]);

        if (request('inform_new_email'))
        {
            $user->notify(new EmailChangedToNew($oldEmail, $user->StrUserID));
        }

        if (setting('users.email_must_be_verified', 0))
        {
            $user->sendEmailVerificationNotification();
        }

        return response()->json([
            'title' => 'Success',
            'message' => "User's E-mail has been successfully changed.<br/><br/>New Email:<br/><input type='email' value='{$user->Email}' class='form-control bg-200' readonly />",
            'icon' => 'success',
        ]);
    }

    public function updateBalance(User $user)
    {
        request()->validate([
            'balance' => ['required', 'numeric', 'min:0'],
            'balance_point' => ['required', 'numeric', 'min:0'],
            'reason' => ['nullable', 'string', 'max:250'],
        ]);

        $compareBalance = bccomp(request()->balance, $user->balance->balance, 2);
        $compareBalancePoint = bccomp(request()->balance_point, $user->balance->balance_point, 2);

        if ($compareBalance === 1)
        {
            $user->balance->increase('balance', bcsub(request()->balance, $user->balance->balance, 2), config('constants.balance.source.admin'), request('reason', 'Added by Admin'), auth()->user()->JID);
        }
        elseif ($compareBalance === -1)
        {
            $user->balance->decrease('balance', bcsub($user->balance->balance, request()->balance, 2), config('constants.balance.source.admin'), request('reason', 'Removed by Admin'), auth()->user()->JID);
        }

        if ($compareBalancePoint === 1)
        {
            $user->balance->increase('balance_point', bcsub(request()->balance_point, $user->balance->balance_point, 2), config('constants.balance.source.admin'), request('reason', 'Added by Admin'), auth()->user()->JID);
        }
        elseif ($compareBalancePoint === -1)
        {
            $user->balance->decrease('balance_point', bcsub($user->balance->balance_point, request()->balance_point, 2), config('constants.balance.source.admin'), request('reason', 'Removed by Admin'), auth()->user()->JID);
        }

        return response()->json([
            'title' => 'Success!',
            'message' => 'User\'s balance has been successfully updated.',
            'icon' => 'success',
        ]);
    }

    public function updateSilk(User $user)
    {
        request()->validate([
            'silk_own' => ['required', 'integer', 'min:0'],
            'silk_gift' => ['required', 'integer', 'min:0'],
            'silk_point' => ['required', 'integer', 'min:0'],
            'reason' => ['nullable', 'string', 'max:250'],
        ]);

        $compareSilkOwn = bccomp(request('silk_own'), $user->silk->silk_own);
        $compareSilkGift = bccomp(request('silk_gift'), $user->silk->silk_gift);
        $compareSilkPoint = bccomp(request('silk_point'), $user->silk->silk_point);

        if ($compareSilkOwn === 1)
        {
            $user->silk->increase(config('constants.silk.type.id.silk_own'), request('silk_own') - $user->silk->silk_own, config('constants.silk.reason.inc.silk_own'), request('reason', 'Added by Admin'));
        }
        elseif ($compareSilkOwn === -1)
        {
            $user->silk->decrease(config('constants.silk.type.id.silk_own'), $user->silk->silk_own - request('silk_own'), config('constants.silk.reason.dec.silk_own'), request('reason', 'Removed by Admin'));
        }

        if ($compareSilkGift === 1)
        {
            $user->silk->increase(config('constants.silk.type.id.silk_gift'), request('silk_gift') - $user->silk->silk_gift, config('constants.silk.reason.inc.silk_gift'), request('reason', 'Added by Admin'));
        }
        elseif ($compareSilkGift === -1)
        {
            $user->silk->decrease(config('constants.silk.type.id.silk_gift'), $user->silk->silk_gift - request('silk_gift'), config('constants.silk.reason.dec.silk_gift'), request('reason', 'Removed by Admin'));
        }

        if ($compareSilkPoint === 1)
        {
            $user->silk->increase(config('constants.silk.type.id.silk_point'), request('silk_point') - $user->silk->silk_point, config('constants.silk.reason.inc.silk_point'), request('reason', 'Added by Admin'));
        }
        elseif ($compareSilkPoint === -1)
        {
            $user->silk->decrease(config('constants.silk.type.id.silk_point'), $user->silk->silk_point - request('silk_point'), config('constants.silk.reason.dec.silk_point'), request('reason', 'Removed by Admin'));
        }

        return response()->json([
            'title' => 'Success!',
            'message' => 'User\'s Silk data has been successfully updated.',
            'icon' => 'success',
        ]);
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

        $paginator = User::select(['StrUserID', 'JID'])->where('StrUserID', 'like', "{$search}%")->orWhere('Name', 'like', "{$search}%")->orWhereHas('characternames', function (Builder $query) use ($search)
        {
            $query->where('CharName', 'like', "{$search}%");
        })->with('characternames')->paginate(10);

        $newCollection = $paginator->getCollection()->map(function (User $item)
        {
            $characterNames = $item->characternames->map(function (ShardCharNames $characterName)
            {
                return $characterName->CharName;
            })->join(', ');

            return [
                'id' => $item->JID,
                'text' => $item->StrUserID . ($characterNames != '' ? " - Characters: ({$characterNames})" : ''),
            ];
        });

        $paginator->setCollection($newCollection);

        return $paginator;
    }
}
