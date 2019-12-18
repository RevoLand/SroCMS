<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteProviderIp extends Model
{
    protected $connection = 'srocms';
    protected $table = 'vote_provider_ips';
    protected $guarded = [];
}
