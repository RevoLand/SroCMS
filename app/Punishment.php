<?php

namespace App;

use Carbon\Carbon;
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

    /*
        'punishment' => [
            'login' => '1',
            'login_inspection' => '2',
            'p2p_trade' => '3',
            'chat' => '4',
        ],
    */

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
        return $query->where('BlockEndTime', '>', Carbon::now());
    }
}
