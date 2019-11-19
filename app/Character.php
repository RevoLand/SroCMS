<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'CharID';
    protected $table = '_Char';
    protected $guarded = [];

    public function shardUser()
    {
        return $this->belongsTo('App\ShardUser', 'CharID', 'CharID');
    }

    public function logEventChar()
    {
        return $this->hasMany('App\LogEventChar', 'CharID', 'CharID')->latest();
    }

    public function guild()
    {
        return $this->hasOne('App\Guild', 'ID', 'GuildID');
    }
}
