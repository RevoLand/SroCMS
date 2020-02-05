<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallItemGroup extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function items()
    {
        return $this->hasMany(ItemMallItem::class);
    }
}
