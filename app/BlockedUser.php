<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BlockedUser extends Model
{
    public $timestamps = false;
    protected $connection = 'account';
    protected $table = '_BlockedUser';
    protected $primaryKey; // UserJID, Type
    protected $guarded = [];
    protected $dates = [
        'timeBegin',
        'timeEnd',
    ];

    /*
        'punishment' => [
            'login' => '1',
            'login_inspection' => '2',
            'p2p_trade' => '3',
            'chat' => '4',
        ],
    */

    public function punishment()
    {
        return $this->belongsTo(Punishment::class, 'SerialNo', 'SerialNo');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'JID');
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
