<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $attributes = [
        'balance' => 0,
        'balance_point' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function logs()
    {
        return $this->hasMany(UserBalanceLog::class, 'user_id', 'user_id');
    }

    public function increase(string $type, float $balance, int $source, string $comment = null, int $source_user_id = null): void
    {
        if (!$this->exists)
        {
            $this->saveOrFail();
        }

        $balanceBefore = $this->{$type};
        $this->increment($type, $balance);
        $balanceAfter = $this->{$type};

        $this->logBalanceChange(config('constants.balance.log_type.' . $type), $balanceAfter, $balanceBefore, $source, $comment, $source_user_id);
    }

    public function decrease(string $type, float $balance, int $source, string $comment = null, int $source_user_id = null): void
    {
        if (!$this->exists)
        {
            $this->saveOrFail();
        }

        $balanceBefore = $this->{$type};
        $this->decrement($type, $balance);
        $balanceAfter = $this->{$type};

        $this->logBalanceChange(config('constants.balance.log_type.' . $type), $balanceAfter, $balanceBefore, $source, $comment, $source_user_id);
    }

    private function logBalanceChange(int $type, float $balanceAfter, float $balanceBefore, int $source, string $comment = null, int $source_user_id = null): void
    {
        $this->logs()->create([
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'balance_type' => $type,
            'source' => $source,
            'source_user_id' => $source_user_id,
            'comment' => $comment,
        ]);
    }
}
