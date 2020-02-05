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
        return $this->hasMany(ItemMallItemGroup::class);
    }

    public function itemGroupsEnabled()
    {
        return $this->hasMany(ItemMallItemGroup::class)->enabled();
    }
}
