<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function scopeEnabled($query)
    {
        return $query->where('Enabled', true);
    }
}
