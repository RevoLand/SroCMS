<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $connection = 'srocms';
    protected $table = 'login_attempts';
    protected $guarded = [];
}
