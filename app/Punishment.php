<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    const CREATED_AT = 'RaiseTime';
    const UPDATED_AT = null;
    protected $connection = 'account';
    protected $table = '_Punishment';
    protected $primaryKey = 'SerialNo';
    protected $guarded = [];
    protected $dates = [
        'RaiseTime',
        'BlockStartTime',
        'BlockEndTime',
        'PunishTime',
    ];

    public function blockeduser()
    {
        return $this->hasOne(BlockedUser::class, 'SerialNo', 'SerialNo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }

    public function executor()
    {
        return $this->belongsTo(User::class, 'Executor', 'JID');
    }

    public function scopeActive($query)
    {
        return $query->where('BlockEndTime', '>', now());
    }
}
