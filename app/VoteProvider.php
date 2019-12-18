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
        return $this->hasMany('App\VoteProviderRewardGroup', 'vote_provider_id');
    }

    public function canUserVote()
    {
        return Auth::user()->voteLogs->where('vote_provider_id', $this->id)->where('voted', true)->filter(function ($voteLog)
        {
            return $voteLog->updated_at && $voteLog->updated_at->addMinutes($this->minutes_between_votes) > Carbon::now();
        })->count() == 0;
    }

    public function getVoteUrl($voteLogId)
    {
        return $this->url . (parse_url($this->url, PHP_URL_QUERY) ? '&' : '?') . http_build_query([$this->url_user_name => $voteLogId]);
    }
}
