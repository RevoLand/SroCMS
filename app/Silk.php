<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Silk extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $connection = 'account';
    protected $table = 'SK_Silk';
    protected $primaryKey = 'JID';
    protected $guarded = [];
    protected $attributes = [
        'silk_own' => 0,
        'silk_gift' => 0,
        'silk_point' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'JID', 'JID');
    }

    public function increase(int $type, int $amount, int $reason, string $desc = null): void
    {
        if (!$this->exists)
        {
            $this->saveOrFail();
        }

        $this->increment(config('constants.silk.type.name.' . $type), $amount);

        $this->logSilkChange($type, $amount, $reason, $desc);
    }

    public function decrease(int $type, int $amount, int $reason, string $desc = null): void
    {
        if (!$this->exists)
        {
            $this->saveOrFail();
        }

        $this->decrement(config('constants.silk.type.name.' . $type), $amount);

        $this->logSilkChange($type, $amount, $reason, $desc);
    }

    private function logSilkChange(int $type, int $amount, int $reason, string $desc = null): void
    {
        $remain = $this->{config('constants.silk.type.name.' . $type)};

        $this->user->silkBuyList()->create([
            'Silk_Type' => $type,
            'Silk_Reason' => $reason,
            'Silk_Offset' => $amount,
            'Silk_Remain' => $remain,
            'BuyQuantity' => '1',
            'SlipPaper' => $desc,
        ]);

        $this->user->silkChangeByWeb()->create([
            'silk_remain' => $remain,
            'silk_offset' => $amount,
            'silk_type' => $type,
            'reason' => $reason,
        ]);
    }
}
