<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderRewardGroup extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function rewards()
    {
        return $this->hasMany(VoteProviderReward::class);
    }
}
