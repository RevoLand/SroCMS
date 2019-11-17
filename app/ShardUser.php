<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShardUser extends Model
{
    public $connection = 'shard';
    public $timestamps = false;
    protected $table = '_User';
    protected $guarded = [];

    public function characters()
    {
        return $this->hasMany('App\Character', 'CharID', 'CharID');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'JID', 'UserJID');
    }
}
