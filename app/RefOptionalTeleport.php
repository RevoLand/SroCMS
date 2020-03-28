<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefOptionalTeleport extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefOptionalTeleport';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function zoneName()
    {
        return $this->hasOne(Name::class, 'key', 'ZoneName128');
    }
}
