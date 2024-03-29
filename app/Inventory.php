<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey;
    protected $table = '_Inventory';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharID', 'CharID');
    }

    public function item()
    {
        return $this->hasOne(Item::class, 'ID64', 'ItemID');
    }

    public function scopeIgnoreDummy($query)
    {
        return $query->where('ItemID', '!=', 0);
    }

    public function scopeEquipped($query)
    {
        return $query->whereIn('Slot', config('constants.inventory.slots'));
    }
}
