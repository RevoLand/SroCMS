<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuildMember extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_GuildMember';
    protected $primaryKey;
    protected $guarded = [];

    public function guild()
    {
        return $this->hasOne('App\Guild', 'ID', 'GuildID');
    }

    public function character()
    {
        return $this->hasOne('App\Character', 'CharID', 'CharID');
    }
}
