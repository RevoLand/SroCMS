<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharTriJob extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'CharID';
    protected $table = '_CharTrijob';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharID', 'CharID');
    }
}
