<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_Guild';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function characters()
    {
        return $this->hasMany('App\Character', 'GuildID', 'ID');
    }

    public function members()
    {
        return $this->hasMany('App\GuildMember', 'GuildID', 'ID');
    }

    public function siegeFortress()
    {
        return $this->hasOne('App\SiegeFortress', 'GuildID', 'ID');
    }
}
