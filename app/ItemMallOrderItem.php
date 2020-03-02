<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallOrderItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function itemgroup()
    {
        return $this->belongsTo(ItemMallItemGroup::class);
    }

    public function order()
    {
        return $this->belongsTo(ItemMallOrder::class);
    }
}
