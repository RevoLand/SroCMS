<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketBan extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $appends = ['active'];
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

    public function assigner()
    {
        return $this->belongsTo(User::class, 'assigner_user_id', 'JID');
    }

    public function getActiveAttribute()
    {
        return !isset($this->ban_cancelled_at) && $this->ban_start <= now() && $this->ban_end >= now();
    }

    public function scopeActive($query)
    {
        return $query->whereNull('ban_cancelled_at')
            ->where('ban_start', '<=', now())
            ->where('ban_end', '>=', now());
    }
}
