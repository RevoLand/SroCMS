<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'ID64';
    protected $table = '_Items';
    protected $guarded = [];

    public function objCommon()
    {
        return $this->hasOne(ObjCommon::class, 'ID', 'RefItemID');
    }
}
