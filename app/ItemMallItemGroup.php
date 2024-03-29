<?php

namespace App;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ItemMallItemGroup extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    protected $dates = [
        'available_after',
        'available_until',
        'created_at',
        'updated_at',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function items()
    {
        return $this->hasMany(ItemMallItem::class);
    }

    public function categories()
    {
        return $this->belongsToMany(ItemMallCategory::class);
    }

    public function categoriesEnabled()
    {
        return $this->categories()->enabled();
    }

    public function orders()
    {
        return $this->hasMany(ItemMallOrderItem::class);
    }

    public function userOrders()
    {
        return $this->orders()->where('user_id', auth()->user()->JID);
    }

    public function getTotalOrdersAttribute()
    {
        return $this->orders->sum('quantity');
    }

    public function getTotalUserOrdersAttribute()
    {
        return $this->userOrders->sum('quantity');
    }

    public function priceChanges()
    {
        return $this->hasMany(ItemMallItemGroupPriceChange::class);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($query)
        {
            $query->where('available_after', '<=', Carbon::now())
                ->orWhere('available_after', '=', null);
        })->where(function ($query)
        {
            $query->where('available_until', '>=', Carbon::now())
                ->orWhere('available_until', '=', null);
        });
    }

    public function getActiveAttribute()
    {
        return (!$this->available_after || $this->available_after <= Carbon::now()) && (!$this->available_until || $this->available_until >= Carbon::now());
    }
}
