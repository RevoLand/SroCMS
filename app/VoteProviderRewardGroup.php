<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderRewardGroup extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function voteproviders()
    {
        return $this->belongsToMany(VoteProvider::class);
    }

    public function rewards()
    {
        return $this->hasMany(VoteProviderReward::class);
    }

    public function logs()
    {
        return $this->hasMany(VoteLog::class, 'selected_reward_group_id');
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
