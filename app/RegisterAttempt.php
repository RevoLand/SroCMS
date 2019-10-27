<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterAttempt extends Model
{
    protected $connection = 'srocms';
    protected $table = 'register_attempts';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
