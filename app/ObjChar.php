<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjChar extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjChar';
    protected $primaryKey = 'ID';
    protected $guarded = [];
}
