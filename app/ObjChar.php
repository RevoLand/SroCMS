<?php

namespace App;

use App\Scopes\NoLockScope;
use Illuminate\Database\Eloquent\Model;

class ObjChar extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjChar';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    protected static function booted()
    {
        static::addGlobalScope(new NoLockScope());
    }
}
