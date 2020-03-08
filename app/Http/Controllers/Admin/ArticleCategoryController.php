<?php

namespace App\Http\Controllers\Admin;

use App\ArticleCategory;
use App\DataTables\ArticleCategoriesDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArticleCategoriesDataTable $dataTable)
    {
        return $dataTable->render('articles.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articles.categories.create');
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
        $this->validateCategory();

        $category = ArticleCategory::create([
            'name' => request('name'),
            'slug' => request('slug'),
            'enabled' => request('enabled'),
        ]);

        if (request()->has('generate-slug'))
        {
            $category->generateSlug();
            $category->save();
        }

        return redirect()->route('admin.articles.categories.edit', $category)->with('message', 'Article Category successfully created.');
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
     * @param App\ArticleCategory $categeory
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $category)
    {
        return view('articles.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleCategory $category)
    {
        $this->validateCategory();

        $category->update([
            'name' => request('name'),
            'slug' => request('slug'),
            'enabled' => request('enabled'),
        ]);

        if (request()->has('generate-slug') || is_null(request('slug')))
        {
            $category->generateSlug();
            $category->save();
        }

        return redirect()->route('admin.articles.categories.edit', $category)->with('message', 'Category is successfully updated.');
    }

    public function toggleEnabled(Request $request, ArticleCategory $category)
    {
        $category->update([
            'enabled' => !$category->enabled,
        ]);

        return response()->json(['message' => 'Category Enabled state successfully updated. New State: ' . (($category->enabled) ? 'Enabled' : 'Disabled')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category is successfully deleted.']);
    }

    private function validateCategory()
    {
        request()->validate([
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate-slug' => ['sometimes', 'boolean'],
            'name' => ['required', 'string'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
