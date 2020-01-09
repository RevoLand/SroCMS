<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SilkBuyList extends Model
{
    const CREATED_AT = 'RegDate';
    const UPDATED_AT = null;

    protected $connection = 'account';
    protected $table = 'SK_SilkBuyList';
    protected $primaryKey = 'BuyNo';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserJID', 'JID');
    }
}
