<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingCampMember extends Model
{
    const OWNER = 0;
    const MEMBER = 2;
    public $timestamps = false;
    public $incrementing = false;
    protected $connection = 'shard';
    protected $primaryKey = 'CharID';
    protected $table = '_TrainingCampMember';
    protected $guarded = [];

    public function academy()
    {
        return $this->belongsTo(TrainingCamp::class, 'CampID', 'ID');
    }

    public function character()
    {
        return $this->belongsTo(Character::class, 'CharID', 'CharID');
    }

    public function scopeOwner($query)
    {
        return $query->where('MemberClass', TrainingCampMember::OWNER);
    }

    public function scopeMember($query)
    {
        return $query->where('MemberClass', TrainingCampMember::MEMBER);
    }
}
