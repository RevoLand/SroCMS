<?php

namespace App;

use Carbon\Carbon;
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

    public function categories()
    {
        return $this->belongsToMany(ItemMallItemGroup::class);
    }

    public function categoriesEnabled()
    {
        return $this->belongsToMany(ItemMallItemGroup::class)->enabled();
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
