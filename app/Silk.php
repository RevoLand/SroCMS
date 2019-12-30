<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Silk extends Model
{
    public $timestamps = false;
    protected $connection = 'account';
    protected $table = 'SK_Silk';
    protected $primaryKey = 'JID';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'JID', 'JID');
    }
}
