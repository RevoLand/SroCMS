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
        echo $this->getLoginBlockedUsers();
        echo '<br/>';
        echo $this->getLoginTempBlockedUsers();
        echo '<br/>';
        echo $this->getTradeBlockedUsers();
        echo '<br/>';
        echo $this->getChatBlockedUsers();
        echo '<br/>';

        foreach ($this->getItemMallBestSellers() as $item)
        {
            echo $item->refItem->getName() . ' | ' . $item->sales . '<br />';
        }
    }

    private function getLoginBlockedUsers()
    {
        return User::has('activeLoginBlock')->count();
    }

    private function getLoginTempBlockedUsers()
    {
        return User::has('activeLoginTempBlock')->count();
    }

    private function getTradeBlockedUsers()
    {
        return User::has('activeTradeBlock')->count();
    }

    private function getChatBlockedUsers()
    {
        return User::has('activeChatBlock')->count();
    }

    private function getItemMallBestSellers()
    {
        return LogCashItem::daysSince(30)->group()->with('refItem.name')->orderByDesc('sales')->get();
    }
}
