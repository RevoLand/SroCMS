<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalanceLog extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $appends = ['balance_difference'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_user_id', 'JID');
    }

    public function getBalanceDifferenceAttribute()
    {
        return bcsub($this->balance_after, $this->balance_before, 2);
    }

    public function scopeSource($query, $source)
    {
        return $query->where('source', $source);
    }

    public function scopeSourceUser($query, $sourceUserId)
    {
        return $query->where('source_user_id', $sourceUserId);
    }
}
