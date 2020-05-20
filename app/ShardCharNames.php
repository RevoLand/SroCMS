<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShardCharNames extends Model
{
    public $timestamps = false;
    protected $connection = 'account';
    protected $table = 'SR_ShardCharNames';
    protected $primaryKey = 'CharName';
    protected $keyType = 'string';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharName', 'CharName16');
    }
}
