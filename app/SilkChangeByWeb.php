<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SilkChangeByWeb extends Model
{
    public $timestamps = false;

    protected $connection = 'account';
    protected $table = 'SK_SilkChange_BY_Web';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'JID', 'JID');
    }
}
