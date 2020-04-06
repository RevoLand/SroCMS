<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class UserOrderController extends Controller
{
    public function index(User $user)
    {
        return $user->orders()->with('items')->paginate(5);
    }
}
