<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Menu extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }

    public function scopeName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
