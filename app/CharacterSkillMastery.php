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
        return $this->belongsTo('App\Character', 'CharID', 'CharID');
    }

    public function mastery()
    {
        //return $this->belongsTo('App\SkillMastery', 'MasteryID', 'ID');
    }
}
