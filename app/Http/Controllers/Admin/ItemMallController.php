<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemMallOrdersDataTable;
use App\Http\Controllers\Controller;

class ItemMallController extends Controller
{
    public function index(ItemMallOrdersDataTable $dataTable)
    {
        return $dataTable->render('itemmall.index');
    }
}
