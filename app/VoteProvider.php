<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VoteProvider extends Model
{
    protected $connection = 'srocms';
    protected $table = 'vote_providers';
    protected $guarded = [];

    public function rewardGroups()
    {
        return $this->hasMany(VoteProviderRewardGroup::class)->where('enabled', true);
    }

    public function canUserVote()
    {
        return Auth::user()->voteLogs->where('vote_provider_id', $this->id)->where('voted', true)->filter(function ($voteLog)
        {
            return $voteLog->updated_at && $voteLog->updated_at->addMinutes($this->minutes_between_votes) > Carbon::now();
        })->count() == 0;
    }

    public function getVoteUrl(VoteLog $voteLog)
    {
        return $this->url . (parse_url($this->url, PHP_URL_QUERY) ? '&' : '?') . http_build_query([$this->url_user_name => $voteLog->secret]);
    }

    public function lastVoteLog($userId)
    {
        return $this->hasOne(VoteLog::class)->where('user_id', $userId)->latest('updated_at')->first();
    }

    public function lastActiveVoteLog($userId)
    {
        return $this->hasOne(VoteLog::class)->where('user_id', $userId)->where('active', true)->latest('updated_at')->first();
    }
}
