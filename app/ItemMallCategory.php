<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallCategory extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function itemGroups()
    {
        return $this->belongsToMany(ItemMallItemGroup::class);
    }

    public function itemGroupsEnabled()
    {
        return $this->belongsToMany(ItemMallItemGroup::class)->enabled();
    }
}
