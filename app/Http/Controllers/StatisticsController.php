<?php

namespace App\Http\Controllers;

use App\LogCashItem;
use App\User;

class StatisticsController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        echo $this->getBlockedUserCount();
        echo '<br/>';

        foreach ($this->getItemMallBestSellers() as $item)
        {
            echo $item->refItem->getName() . ' | ' . $item->sales_count . '<br />';
        }
    }

    private function getBlockedUserCount()
    {
        // TODO: Determine with types
        return User::has('activeBlockedUser')->count();
    }

    private function getItemMallBestSellers()
    {
        return LogCashItem::daysSince(30)->group()->with('refItem.name')->latest('sales_count')->get();
    }
}
