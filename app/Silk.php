<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Silk extends Model
{
    protected $connection = 'account';
    protected $table = 'SK_Silk';
    protected $primaryKey = 'JID';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User', 'JID', 'JID');
    }
}
