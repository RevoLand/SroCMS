<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderRewardGroup extends Model
{
    protected $connection = 'srocms';
    protected $table = 'vote_provider_reward_groups';
    protected $guarded = [];

    public function rewards()
    {
        return $this->hasMany('App\VoteProviderReward', 'vote_provider_reward_group_id');
    }
}
