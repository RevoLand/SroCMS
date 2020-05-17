<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    public $timestamps = false;
    protected $connection = 'account';
    protected $table = '_BlockedUser';
    protected $guarded = [];
    protected $dates = [
        'timeBegin',
        'timeEnd',
    ];
    protected $appends = [
        'active',
    ];

    public function punishment()
    {
        return $this->belongsTo(Punishment::class, 'SerialNo', 'SerialNo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }

    public function getActiveAttribute()
    {
        return $this->timeEnd > now();
    }

    public function scopeActive($query)
    {
        return $query->where('timeEnd', '>', Carbon::now());
    }

    public function scopeType($query, $type)
    {
        return $query->where('Type', $type);
    }
}
