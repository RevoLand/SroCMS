<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjCommon extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjCommon';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function objItem()
    {
        return $this->hasOne('App\ObjItem', 'ID', 'Link');
    }

    public function objChar()
    {
        return $this->hasOne('App\ObjChar', 'ID', 'Link');
    }
}
