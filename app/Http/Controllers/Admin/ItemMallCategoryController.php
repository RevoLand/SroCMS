<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ItemMallCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\ItemMallCategory;
use Illuminate\Http\Request;

class ItemMallCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemMallCategoriesDataTable $dataTable)
    {
        return $dataTable->render('itemmall.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('itemmall.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCategory();

        $category = ItemMallCategory::create([
            'name' => request('name'),
            'enabled' => request('enabled'),
            'order' => request('order'),
        ]);

        return response()->json([
            'title' => 'Created!',
            'message' => 'Category is successfully created.',
            'icon' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ItemMallCategory $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemMallCategory $category)
    {
        return view('itemmall.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemMallCategory $category)
    {
        $this->validateCategory();

        $category->update([
            'name' => request('name'),
            'enabled' => request('enabled'),
            'order' => request('order'),
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Category is successfully updated.',
            'icon' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemMallCategory $category)
    {
        $category->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Category is successfully deleted.',
            'icon' => 'success',
        ]);
    }

    public function toggleEnabled(ItemMallCategory $category)
    {
        $category->update([
            'enabled' => !$category->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Category enabled state has been successfully updated.',
            'icon' => 'success',
        ]);
    }

    private function validateCategory()
    {
        return request()->validate([
            'name' => ['required', 'string'],
            'enabled' => ['required', 'boolean'],
            'order' => ['nullable', 'integer'],
        ]);
    }
}
