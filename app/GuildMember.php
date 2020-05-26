<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GuildMember extends Model
{
    const OWNER = 0;
    const MEMBER = 10;
    const CREATED_AT = 'JoinDate';
    const UPDATED_AT = null;
    protected $connection = 'shard';
    protected $table = '_GuildMember';
    protected $primaryKey;
    protected $guarded = [];
    protected $dateFormat = 'Y-m-d H:i:s';

    public function guild()
    {
        return $this->hasOne(Guild::class, 'ID', 'GuildID');
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'CharID', 'CharID');
    }

    public function hasPermission(int $permission)
    {
        return $this->Permission & $permission;
    }

    public function hasSiegePermission(int $permission)
    {
        return $this->SiegeAuthority & $permission;
    }
}
