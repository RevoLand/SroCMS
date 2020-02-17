<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MagicOpt extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $table = '_RefMagicOpt';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function getStatsAttribute()
    {
        $minValue = $this->Param2 >> 16 ?: $this->Param2;
        $maxValue = (!($this->Param3 >> 9) && !($this->Param3 >> 16)) ? $this->Param3 : (($this->Param4) ? ($this->Param4 & 0xFF ?: $this->Param4 >> 16 ?: $this->Param4) : ($this->Param3 & 0xFF ?: $this->Param3 >> 16));

        return (object) ['minValue' => $minValue, 'maxValue' => $maxValue];
    }

    public function name()
    {
        return $this->hasOne(Name::class, 'key', 'MOptName128');
    }

    public function scopeEnabled($query)
    {
        return $query->where('Service', 1);
    }
}
