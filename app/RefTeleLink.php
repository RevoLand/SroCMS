<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RefTeleLink extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefTeleLink';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(RefTeleport::class, 'OwnerTeleport', 'ID');
    }

    public function target()
    {
        return $this->belongsTo(RefTeleport::class, 'TargetTeleport', 'ID');
    }
}
