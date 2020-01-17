<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'JID', 'user_id');
    }

    public function referrerUser()
    {
        return $this->belongsTo(User::class, 'JID', 'referrer_user_id');
    }
}
