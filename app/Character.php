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

    public function user()
    {
        return $this->belongsTo(ShardUser::class, 'CharID', 'CharID');
    }

    public function logEventChar()
    {
        return $this->hasMany(LogEventChar::class, 'CharID', 'CharID')->latest();
    }

    public function guild()
    {
        return $this->hasOne(Guild::class, 'ID', 'GuildID');
    }

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'CharID', 'CharID');
    }

    public function skillMastery()
    {
        return $this->hasMany(CharacterSkillMastery::class, 'CharID');
    }
}
