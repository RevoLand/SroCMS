<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessageHistory extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function message()
    {
        return $this->belongsTo(TicketMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }
}
