<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemMallItemGroupsDataTable;
use App\Http\Controllers\Controller;
use App\ItemMallCategory;
use App\ItemMallItemGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemMallItemGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemMallItemGroupsDataTable $dataTable)
    {
        return $dataTable->render('itemmall.itemgroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ItemMallCategory::enabled()->get();

        return view('itemmall.itemgroups.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateItemGroup();

        $itemGroup = ItemMallItemGroup::create([
            'name' => request('name'),
            'description' => request('description'),
            'image' => request('image'),
            'payment_type' => request('payment_type'),
            'price' => request('price'),
            'on_sale' => request('on_sale'),
            'price_before' => request('price_before'),
            'limit_total_purchases' => request('limit_total_purchases'),
            'total_purchase_limit' => request('total_purchase_limit'),
            'limit_user_purchases' => request('limit_user_purchases'),
            'user_purchase_limit' => request('user_purchase_limit'),
            'use_customized_referral_options' => request('use_customized_referral_options'),
            'referral_commission_enabled' => request('referral_commission_enabled'),
            'referral_commission_reward_type' => request('referral_commission_reward_type'),
            'referral_commission_percentage' => request('referral_commission_percentage'),
            'featured' => request('featured'),
            'order' => request('order'),
            'available_after' => request('available_after'),
            'available_until' => request('available_until'),
            'enabled' => request('enabled'),
        ]);

        $itemGroup->categories()->attach(request('categories'));

        return redirect()->route('admin.itemmall.itemgroups.edit', $itemGroup)->with('message', 'Item Group is successfully created. You can add items to the group now!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ItemMallItemGroup $itemgroup)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemMallItemGroup $itemgroup)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemMallItemGroup $itemgroup)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemMallItemGroup $itemgroup)
    {
        $itemgroup->delete();

        if (request()->expectsJson())
        {
            return response()->json(['message' => 'Selected item group is successfully deleted']);
        }

        return redirect()->route('admin.itemmall.itemgroups.index')->with('message', 'Selected item group is successfully deleted');
    }

    public function toggleEnabled(ItemMallItemGroup $itemgroup)
    {
        $itemgroup->update([
            'enabled' => !$itemgroup->enabled,
        ]);

        return response()->json(['message' => 'Item Group Enabled state has been successfully changed.']);
    }

    private function validateItemGroup()
    {
        return request()->validate([
            'name' => ['required', 'string'],
            'categories' => ['required', 'array', 'exists:App\ItemMallCategory,id'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string'],
            'payment_type' => ['required', 'integer', Rule::in(config('constants.payment_types'))],
            'on_sale' => ['required', 'boolean'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'price_before' => ['nullable', 'numeric'],
            'limit_total_purchases' => ['required', 'boolean'],
            'total_purchase_limit' => ['nullable', 'integer'],
            'limit_user_purchases' => ['required', 'boolean'],
            'user_purchase_limit' => ['nullable', 'integer'],
            'use_customized_referral_options' => ['required', 'boolean'],
            'referral_commission_enabled' => ['required', 'boolean'],
            'referral_commission_reward_type' => ['nullable', 'integer', Rule::in(config('constants.payment_types'))],
            'referral_commission_percentage' => ['nullable', 'integer'],
            'featured' => ['required', 'boolean'],
            'order' => ['required', 'integer'],
            'enabled' => ['required', 'boolean'],
            'available_after' => ['nullable', 'date'],
            'available_until' => ['nullable', 'date'],
        ]);
    }
}
