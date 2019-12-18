<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    protected $connection = 'srocms';
    protected $table = 'vote_logs';
    protected $guarded = [];

    public function rewardgroup()
    {
        return $this->hasOne('App\VoteProviderRewardGroup', 'id', 'selected_reward_group_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'JID', 'user_id');
    }
}
