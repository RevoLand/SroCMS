<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ItemMallOrder;
use Illuminate\Http\Request;

class ItemMallOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param \App\ItemMallOrder $itemMallOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ItemMallOrder $order)
    {
        $order->load([
            'items.itemgroup', 'user',
        ]);

        // ddd($order);

        return view('itemmall.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemMallOrder $itemMallOrder)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemMallOrder $itemMallOrder)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemMallOrder $itemMallOrder)
    {
    }
}
