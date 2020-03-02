<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpinItem extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function epin()
    {
        return $this->belongsTo(Epin::class);
    }
}
