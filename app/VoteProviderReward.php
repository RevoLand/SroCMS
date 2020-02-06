<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderReward extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
