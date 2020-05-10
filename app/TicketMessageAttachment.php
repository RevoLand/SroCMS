<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class TicketMessageAttachment extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];
    protected $appends = ['file_url', 'last_modified'];

    public function ticketMessage()
    {
        return $this->belongsTo(TicketMessage::class);
    }

    public function ticket()
    {
        return $this->ticketMessage->ticket;
    }

    public function getFileUrlAttribute()
    {
        return asset(Storage::url('tickets/' . $this->name));
    }

    public function getLastModifiedAttribute()
    {
        return Storage::disk('tickets')->lastModified($this->name);
    }
}
