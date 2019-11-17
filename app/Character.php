<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $connection = 'shard';
    public $timestamps = false;
    protected $primaryKey = 'CharID';
    protected $table = '_Char';
    protected $guarded = [];

    public function sharduser()
    {
        return $this->belongsTo('App\ShardUser', 'CharID', 'CharID');
    }
}
