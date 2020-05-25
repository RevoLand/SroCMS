<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiegeFortress extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey = 'FortressID';
    protected $table = '_SiegeFortress';
    protected $guarded = [];

    public function guild()
    {
        return $this->belongsTo(Guild::class, 'GuildID', 'ID');
    }

    public function getImageAttribute()
    {
        return asset('vendor/img/silkroad/siege/' . $this->FortressID . '.png');
    }

    public function getNameAttribute()
    {
        return config('constants.siege.names.' . $this->FortressID);
    }
}
