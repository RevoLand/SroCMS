<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEventChar extends Model
{
    public $timestamps = false;
    protected $connection = 'log';
    protected $table = '_LogEventChar';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo('App\Character', 'CharID', 'CharID');
    }
}
