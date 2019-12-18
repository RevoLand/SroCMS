<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderReward extends Model
{
    protected $connection = 'srocms';
    protected $table = 'vote_provider_rewards';
    protected $guarded = [];
}
