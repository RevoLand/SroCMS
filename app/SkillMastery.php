<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillMastery extends Model
{
    public $timestamps = false;
    protected $connection = 'shard';
    protected $primaryKey;
    protected $table = '_RefSkillMastery';
    protected $guarded = [];
}
