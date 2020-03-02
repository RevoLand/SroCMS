<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function logs()
    {
        return $this->hasMany(UserBalanceLog::class, 'user_id', 'user_id');
    }

    public function increase($type, $balance, $source, $comment = '', $source_user_id = '')
    {
        $balanceBefore = $this->{$type};
        $this->increment($type, $balance);
        $balanceAfter = $this->{$type};

        $this->logBalanceChange(config('constants.balance.log_type.' . $type), $balanceAfter, $balanceBefore, $source, $comment, $source_user_id);
    }

    public function decrease($type, $balance, $source, $comment = '', $source_user_id = '')
    {
        $balanceBefore = $this->{$type};
        $this->decrement($type, $balance);
        $balanceAfter = $this->{$type};

        $this->logBalanceChange(config('constants.balance.log_type.' . $type), $balanceAfter, $balanceBefore, $source, $comment, $source_user_id);
    }

    private function logBalanceChange($type, $balanceAfter, $balanceBefore, $source, $comment = '', $source_user_id = '')
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
