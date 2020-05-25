<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharNameList extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $connection = 'shard';
    protected $primaryKey = 'CharID';
    protected $table = '_CharNameList';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharID', 'CharID');
    }
}
