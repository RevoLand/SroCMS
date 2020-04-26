<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LogCashItem extends Model
{
    const CREATED_AT = 'EventTime';
    const UPDATED_AT = null;
    protected $connection = 'log';
    protected $table = '_LogCashItem';
    protected $primaryKey = 'ID';
    protected $guarded = [];

    public function scopeCharacter($query, $characterId)
    {
        return $query->where('CharID', $characterId);
    }

    public function scopeDaysSince($query, $days)
    {
        return $query->where('EventTime', '>=', Carbon::now()->subDays($days));
    }

    public function scopeGroup($query)
    {
        return $query->groupBy('RefItemID')->select('RefItemID', \DB::raw('count(*) as sales'));
    }

    public function refItem()
    {
        return $this->belongsTo(ObjCommon::class, 'RefItemID', 'ID');
    }
}
