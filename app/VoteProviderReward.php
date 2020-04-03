<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderReward extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $appends = ['type_name'];

    public function rewardgroup()
    {
        return $this->belongsTo(VoteProviderRewardGroup::class, 'vote_provider_reward_group_id');
    }

    public function scopeRewardGroupId($query, $rewardgroup)
    {
        return $query->where('vote_provider_reward_group_id', $rewardgroup);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function getTypeNameAttribute()
    {
        return config('constants.payment_types.' . $this->type);
    }
}
