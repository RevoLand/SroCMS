<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $connection = 'srocms';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'JID');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id', 'JID');
    }

    public function order()
    {
        return $this->belongsTo(ItemMallOrder::class, 'item_mall_order_id');
    }

    public function scopeActive($query)
    {
        return $query->where('Status', '!=', config('constants.ticket_system.status_from_name.Closed'));
    }
}
