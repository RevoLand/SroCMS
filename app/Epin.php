<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epin extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function createrUser()
    {
        return $this->belongsTo(User::class, 'creater_user_id', 'JID');
    }

    public function items()
    {
        return $this->hasMany(EpinItem::class);
    }
}
