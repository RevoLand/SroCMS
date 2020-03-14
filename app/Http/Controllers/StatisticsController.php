<?php

namespace App\Http\Controllers;

use App\LogCashItem;

class StatisticsController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        foreach ($this->getItemMallBestSellers() as $item)
        {
            echo $item->refItem->getName() . ' | ' . $item->sales_count . '<br />';
        }
    }

    private function getItemMallBestSellers()
    {
        return LogCashItem::daysSince(30)->group()->with('refItem.name')->latest('sales_count')->get();
    }
}
