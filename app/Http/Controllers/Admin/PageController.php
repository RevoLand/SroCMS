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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = $request->validate($this->rules());

        $page = new Page();

        $page->fill($values);
        if ($request->has('generate-slug') || is_null($page->slug))
        {
            $page->generateSlug();
        }

        $page->save();

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
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $values = $request->validate($this->rules());

        $page->fill($values);
        if ($request->has('generate-slug') || is_null($page->slug))
        {
            $page->generateSlug();
        }

        $page->save();

        return redirect()->route('admin.pages.edit', $page)->with('message', 'Page updated.');
    }

    public function toggleEnabled(Request $request, Page $page)
    {
        $page->update([
            'enabled' => !$page->enabled,
        ]);

        return response()->json(['message' => 'Enabled state has been changed.']);
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

        return response()->json(['message' => 'Page successfully deleted.']);
    }

    private function rules()
    {
        return [
            'title' => ['required', 'string'],
            'slug' => ['sometimes', 'nullable', 'string'],
            'content' => ['nullable'],
            'view' => ['nullable'],
            'middleware' => ['nullable', 'alpha_dash'],
            'showsidebar' => ['required', 'boolean'],
            'enabled' => ['required', 'boolean'],
        ];
    }
}
