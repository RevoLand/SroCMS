<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketBan extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $dates = [
        'created_at',
        'updated_at',
        'ban_start',
        'ban_end',
        'ban_cancelled_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('ban_cancelled_at')
            ->where('ban_start', '<=', now())
            ->where('ban_end', '>=', now());
    }
}
