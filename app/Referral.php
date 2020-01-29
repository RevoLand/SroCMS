<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function referrerUser()
    {
        return $this->belongsTo(User::class, 'referrer_user_id', 'JID');
    }
}
