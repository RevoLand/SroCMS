<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $touches = ['ticket'];
    protected $appends = ['group_date'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function attachments()
    {
        return $this->hasMany(TicketMessageAttachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function history()
    {
        return $this->hasMany(TicketMessageHistory::class);
    }

    public function getGroupDateAttribute()
    {
        return $this->created_at->toDateString();
    }
}
