<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallOrderItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $appends = ['type_name'];

    public function itemgroup()
    {
        return $this->belongsTo(ItemMallItemGroup::class, 'item_mall_item_group_id');
    }

    public function order()
    {
        return $this->belongsTo(ItemMallOrder::class);
    }

    public function getTypeNameAttribute()
    {
        return config('constants.payment_types.' . $this->payment_type);
    }
}
