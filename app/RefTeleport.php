<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefTeleport extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefTeleport';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function objCommon()
    {
        return $this->belongsTo(ObjCommon::class, 'AssocRefObjID', 'ID')->ignoreDummy();
    }

    public function ownedTeleports()
    {
        return $this->hasMany(RefTeleLink::class, 'OwnerTeleport', 'ID');
    }

    public function targetedTeleports()
    {
        return $this->hasMany(RefTeleLink::class, 'TargetTeleport', 'ID');
    }

    public function zoneName()
    {
        return $this->hasOne(Name::class, 'key', 'ZoneName128');
    }
}
