<?php

namespace App;

use DB;
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

    public function addItem(string $itemCodeName, int $data, int $optLevel): bool
    {
        /*
            0 = Procedure was successfully executed.
            1 = The transaction is in an uncommittable state, rolling back transaction.
            2 = There is an undefined error that has occurred.
            100 = The specified character could not be found.
            101 = The specified characters inventory is already full.
            102 = The specified item could not be found or is disabled.
        */
        return DB::connection('shard')->statement(
            'exec _AddItemByCodeName @intCharID = ?, @vcItemCodeName = ?, @intData = ?, @inyOptLevel = ?',
            [
                $this->CharID,
                $itemCodeName,
                $data,
                $optLevel,
            ]
        );
    }
}
