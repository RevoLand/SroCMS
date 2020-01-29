<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalanceLog extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function getBalanceDifferenceAttribute()
    {
        return $this->balance_after - $this->balance_before;
    }
}
