<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogEventChar extends Model
{
    const CREATED_AT = 'EventTime';
    const UPDATED_AT = null;
    protected $connection = 'log';
    protected $table = '_LogEventChar';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo('App\Character', 'CharID', 'CharID');
    }
}
