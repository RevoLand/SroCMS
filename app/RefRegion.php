<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefRegion extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefRegion';
    protected $primaryKey = 'wRegionID';
    protected $guarded = [];
}
