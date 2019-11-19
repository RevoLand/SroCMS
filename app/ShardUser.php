<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShardUser extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_User';
    protected $guarded = [];
    protected $primaryKey;

    public function characters()
    {
        return $this->hasMany('App\Character', 'CharID', 'CharID');
    }

    public function account()
    {
        return $this->hasOne('App\User', 'JID', 'UserJID');
    }
}
