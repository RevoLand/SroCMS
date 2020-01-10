<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Silk extends Model
{
    public $timestamps = false;
    protected $connection = 'account';
    protected $table = 'SK_Silk';
    protected $primaryKey = 'JID';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'JID', 'JID');
    }

    public function increase($type, $offset, $reason, $desc = '')
    {
        $this->increment(config('constants.silk.type.name.' . $type), $offset);

        $this->logSilkChange($type, $offset, $reason, $desc);
    }

    public function decrease($type, $offset, $reason, $desc = '')
    {
        $this->decrement(config('constants.silk.type.name.' . $type), $offset);

        $this->logSilkChange($type, $offset, $reason, $desc);
    }

    private function logSilkChange($type, $offset, $reason, $desc = '')
    {
        $remain = $this->{config('constants.silk.type.name.' . $type)};

        $this->user->silkBuyList()->create([
            'Silk_Type' => $type,
            'Silk_Reason' => $reason,
            'Silk_Offset' => $offset,
            'Silk_Remain' => $remain,
            'BuyQuantity' => '1',
            'SlipPaper' => $desc,
        ]);

        $this->user->silkChangeByWeb()->create([
            'silk_remain' => $remain,
            'silk_offset' => $offset,
            'silk_type' => $type,
            'reason' => $reason,
        ]);
    }
}
