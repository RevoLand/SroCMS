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
        return $this->belongsTo('App\Character', 'CharID', 'CharID');
    }

    public function item()
    {
        return $this->hasOne('App\Item', 'ID64', 'ItemID');
    }
}
