<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderRewardGroup extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function voteprovider()
    {
        return $this->belongsTo(VoteProvider::class, 'vote_provider_id');
    }

    public function rewards()
    {
        return $this->hasMany(VoteProviderReward::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
