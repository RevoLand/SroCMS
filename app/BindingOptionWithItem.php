<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BindingOptionWithItem extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'nItemDBID';
    protected $table = '_BindingOptionWithItem';
    protected $guarded = [];

    public function scopeType($query, $type)
    {
        return $query->where('bOptType', $type);
    }
}
