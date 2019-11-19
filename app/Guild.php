<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_Guild';
    protected $guarded = [];

    public function characters()
    {
        return $this->hasMany('App\Character', 'GuildID', 'ID');
    }
}
