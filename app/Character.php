<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'CharID';
    protected $table = '_Char';
    protected $guarded = [];
    protected $dates = [
        'LastLogout',
    ];

    public function user()
    {
        return $this->belongsTo(ShardUser::class, 'CharID', 'CharID');
    }

    // public function account()
    // {
    //     // Laravel issue (actually multiple connection issue), doesn't works
    //     // return $this->hasOneThrough(User::class, ShardUser::class, 'CharID', 'JID', 'CharID', 'UserJID');
    // }

    public function logEventChar()
    {
        return $this->hasMany(LogEventChar::class, 'CharID', 'CharID');
    }

    public function guild()
    {
        return $this->hasOne(Guild::class, 'ID', 'GuildID')->ignoreDummy();
    }

    public function guildmember()
    {
        return $this->hasOne(GuildMember::class, 'CharID', 'CharID');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'CharID', 'CharID');
    }

    public function inventoryForAvatar()
    {
        return $this->hasMany(InventoryForAvatar::class, 'CharID', 'CharID');
    }

    public function createdItems()
    {
        return $this->hasMany(Item::class, 'CreaterName', 'CharName16');
    }

    public function job()
    {
        return $this->hasOne(CharTriJob::class, 'CharID', 'CharID');
    }

    public function skillMastery()
    {
        return $this->hasMany(CharacterSkillMastery::class, 'CharID', 'CharID');
    }

    public function academy()
    {
        return $this->hasOneThrough(
            TrainingCamp::class, // _TrainignCamp
            TrainingCampMember::class, // _TrainingCampMember
            'CharID', // _TrainingCampMember.CharID
            'ID', // _TrainingCamp.ID
            'CharID', // _Char.CharID (this)
            'CampID' // _TrainingCampMember.CampID
        );
    }

    public function academyMember()
    {
        return $this->hasOne(TrainingCampMember::class, 'CharID', 'CharID');
    }

    public function charname()
    {
        return $this->hasMany(CharNameList::class, 'CharID', 'CharID');
    }

    public function charnickname()
    {
        return $this->hasMany(CharNickNameList::class, 'CharID', 'CharID');
    }

    public function shardcharname()
    {
        return $this->hasOne(ShardCharNames::class, 'CharName', 'CharName16');
    }

    public function getItemPointAttribute()
    {
        $itemPoint = 0;
        $this->inventory->each(function ($inventoryItem) use (&$itemPoint)
        {
            $itemPoint = bcadd($itemPoint, $inventoryItem->item->itemValue, 2);
        });

        return $itemPoint;
    }

    public function scopeIgnoreDummy($query)
    {
        return $query->where('CharID', '>', '0');
    }
}
