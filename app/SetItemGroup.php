<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetItemGroup extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefSetItemGroup';
    protected $primaryKey = 'ID';
    protected $guarded = [];
}
