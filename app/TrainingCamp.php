<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingCamp extends Model
{
    const CREATED_AT = 'CreationDate';
    const UPDATED_AT = null;
    protected $connection = 'shard';
    protected $primaryKey = 'ID';
    protected $table = '_TrainingCamp';
    protected $guarded = [];
    protected $dates = [
        'CreationDate',
        'LatestEvaluationDate',
    ];

    public function members()
    {
        return $this->hasMany(TrainingCampMember::class, 'CampID', 'ID');
    }

    public function characters()
    {
        return $this->hasManyThrough(
            Character::class, // _Char
            TrainingCampMember::class, // _TrainingCampMember
            'CampID', // _TrainingCampMember.CampID
            'CharID', // _Char.CharID
            'ID', // _TrainingCamp.ID (this)
            'CharID' // _TrainingCampMember.CharID
        );
    }
}
