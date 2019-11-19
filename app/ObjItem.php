<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjItem extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjItem';
    protected $guarded = [];
}
