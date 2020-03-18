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

        if ($request->has('generate-slug'))
        {
            $page->generateSlug();
            $page->save();
        }

        return redirect()->route('admin.pages.edit', $page)->with('message', 'Page created.');
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

        if ($request->has('generate-slug') || is_null($page->slug))
        {
            $page->generateSlug();
            $page->save();
        }

        return redirect()->route('admin.pages.edit', $page)->with('message', 'Page updated.');
    }

    public function toggleEnabled(Request $request, Page $page)
    {
        $page->update([
            'enabled' => !$page->enabled,
        ]);

        return response()->json(['message' => 'Enabled state has been successfully updated.']);
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

        return redirect()->route('admin.pages.index')->with('message', 'Selected Page has been successfully deleted.');
    }

    public function destroyAjax(Page $page)
    {
        $page->delete();

        return response()->json(['message' => 'Selected Page has been successfully deleted.']);
    }

    private function validatePage()
    {
        return request()->validate([
            'title' => ['required', 'string'],
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate-slug' => ['sometimes', 'boolean'],
            'content' => ['nullable'],
            'view' => ['nullable'],
            'middleware' => ['nullable', 'alpha_dash'],
            'showsidebar' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
