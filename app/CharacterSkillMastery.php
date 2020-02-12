<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CharacterSkillMastery extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey;
    protected $table = '_CharSkillMastery';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharID', 'CharID');
    }

    public function mastery()
    {
        return $this->belongsTo(SkillMastery::class, 'MasteryID', 'ID');
    }

    public function scopeMinLevel($query, $minLevel)
    {
        return $query->where('Level', '>=', $minLevel);
    }
}
