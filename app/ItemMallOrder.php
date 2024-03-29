<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMallOrder extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(ItemMallOrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function getTotals()
    {
        return $this->items->groupBy('payment_type')->map(function ($item)
        {
            return $item->sum('total_paid');
        });
    }
}
