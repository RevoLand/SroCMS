<?php

namespace App;

use App\Scopes\NoLockScope;
use Illuminate\Database\Eloquent\Model;

class ObjItem extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefObjItem';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function setItem()
    {
        return $this->belongsTo(SetItemGroup::class, 'SetID', 'ID');
    }

    public function getDegreeAttribute()
    {
        return ceil($this->ItemClass / 3);
    }

    public function getRarityAttribute()
    {
        switch ($this->ItemClass % 3)
        {
            case 0:
                return 'Seal of Sun';
            break;
            case 1:
                return $this->Degree > 10 ? 'Seal of Nova' : 'Seal of Star';
            break;
            case 2:
                return 'Seal of Moon';
            break;
        }
    }

    protected static function booted()
    {
        static::addGlobalScope(new NoLockScope());
    }
}
