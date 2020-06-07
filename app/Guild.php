<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    const CREATED_AT = 'FoundationDate';
    const UPDATED_AT = null;
    protected $connection = 'shard';
    protected $table = '_Guild';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function characters()
    {
        return $this->hasMany(Character::class, 'GuildID', 'ID');
    }

    public function members()
    {
        return $this->hasMany(GuildMember::class, 'GuildID', 'ID');
    }

    public function siegeFortress()
    {
        return $this->hasOne(SiegeFortress::class, 'GuildID', 'ID');
    }

    public function scopeIgnoreDummy($query)
    {
        return $query->where('ID', '!=', 0);
    }
}
