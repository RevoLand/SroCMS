<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $hidden = [
        'secret',
    ];

    public function rewardgroup()
    {
        return $this->hasOne(VoteProviderRewardGroup::class, 'id', 'selected_reward_group_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'JID', 'user_id');
    }

    public function voteProvider()
    {
        return $this->belongsTo(VoteProvider::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeVoted($query)
    {
        return $query->where('voted', true);
    }

    public function scopeNotVoted($query)
    {
        return $query->where('voted', false);
    }

    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeVoteProvider($query, $providerId)
    {
        return $query->where('vote_provider_id', $providerId);
    }
}
