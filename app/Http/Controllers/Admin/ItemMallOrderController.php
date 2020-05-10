<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ItemMallOrder;

class ItemMallOrderController extends Controller
{
    public function show(ItemMallOrder $order)
    {
        ddd($order);
    }
}
