<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VoteProvider extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    protected $hidden = [
        'callback_secret',
    ];

    public function rewardGroups()
    {
        return $this->belongsToMany(VoteProviderRewardGroup::class);
    }

    public function canUserVote()
    {
        return auth()->user()->voteLogsByProviderId($this->id)->voted()->where(function ($voteLogQuery)
        {
            $voteLogQuery->where('updated_at', '>', Carbon::now()->subMinutes($this->minutes_between_votes));
        })->count() == 0;
    }

    public function getVoteUrl(VoteLog $voteLog)
    {
        return $this->url . (parse_url($this->url, PHP_URL_QUERY) ? '&' : '?') . http_build_query([$this->url_user_name => $voteLog->secret]);
    }

    public function lastVoteLogForUser($userId)
    {
        return $this->hasOne(VoteLog::class)->user($userId)->latest('updated_at')->first();
    }

    public function lastVoteLogForAuthUser()
    {
        return $this->lastVoteLogForUser(auth()->user()->JID);
    }

    public function lastActiveVoteLogForUser($userId)
    {
        return $this->hasOne(VoteLog::class)->user($userId)->active()->latest('updated_at')->first();
    }

    public function voteLogs()
    {
        return $this->hasMany(VoteLog::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
