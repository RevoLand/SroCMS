<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TicketCategoriesDataTable;
use App\Http\Controllers\Controller;
use App\TicketCategory;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TicketCategoriesDataTable $dataTable)
    {
        return $dataTable->render('tickets.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validateCategory();

        TicketCategory::create($validated);

        return response()->json([
            'title' => 'Created!',
            'message' => 'Ticket Category is successfully created!',
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
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketCategory $category)
    {
        return view('tickets.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketCategory $category)
    {
        $validated = $this->validateCategory();

        $category->update($validated);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Selected Ticket Category is successfully updated!',
            'icon' => 'success',
        ]);
    }

    public function toggleEnabled(Request $request, TicketCategory $ticketcategory)
    {
        $ticketcategory->update([
            'enabled' => !$ticketcategory->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Category status is successfully updated.<br/>New Status: ' . (($ticketcategory->enabled) ? 'Enabled' : 'Disabled'),
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
    public function destroy(TicketCategory $category)
    {
        $category->delete();

        // TODO: Delete related tickets?

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Ticket Category is successfully deleted.',
            'icon' => 'success',
        ]);
    }

    private function validateCategory()
    {
        return request()->validate([
            'name' => ['required', 'string', 'max:200', 'unique:App\TicketCategory,name'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
