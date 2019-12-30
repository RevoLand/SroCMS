<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuildMember extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_GuildMember';
    protected $primaryKey;
    protected $guarded = [];

    public function guild()
    {
        return $this->hasOne(Guild::class, 'ID', 'GuildID');
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'CharID', 'CharID');
    }
}
