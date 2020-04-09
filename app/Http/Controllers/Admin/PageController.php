<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PagesDataTable;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PagesDataTable $dataTable)
    {
        return $dataTable->render('pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validatePage();

        $page = Page::create([
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content'),
            'view' => request('view'),
            'middleware' => request('middleware'),
            'showsidebar' => request('showsidebar'),
            'enabled' => request('enabled'),
        ]);

        if (request('generate_slug') == 1)
        {
            $page->generateSlug();
            $page->save();
        }

        return response()->json([
            'title' => 'Created!',
            'message' => 'Page is successfully created!.<br /><br /><a href="' . route('admin.pages.edit', $page) . '">Click here</a> to view/edit the created page.',
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
    public function show(Page $page)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->validatePage();

        $page->update([
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content'),
            'view' => request('view'),
            'middleware' => request('middleware'),
            'showsidebar' => request('showsidebar'),
            'enabled' => request('enabled'),
        ]);

        if (request()->has('generate_slug') || !request()->filled('slug'))
        {
            $page->generateSlug();
            $page->save();
        }

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Page is successfully updated!.<br /><br /><a href="' . route('pages.show_page', $page->slug) . '">Click here</a> to view the updated page.',
            'icon' => 'success',
        ]);
    }

    public function toggleEnabled(Request $request, Page $page)
    {
        $page->update([
            'enabled' => !$page->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Enabled state for selected page has been successfully updated.',
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
    public function destroy(Page $page)
    {
        $page->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Page is successfully deleted.',
            'icon' => 'success',
        ]);
    }

    private function validatePage()
    {
        return request()->validate([
            'title' => ['required', 'string'],
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate_slug' => ['sometimes', 'boolean'],
            'content' => ['nullable'],
            'view' => ['nullable'],
            'middleware' => ['nullable', 'alpha_dash'],
            'showsidebar' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
