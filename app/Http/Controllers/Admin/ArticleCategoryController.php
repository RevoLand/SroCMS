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

        if (request('generate_slug') == 1)
        {
            $category->generateSlug();
            $category->save();
        }

        return response()->json([
            'title' => 'Created!',
            'message' => 'Article Category is successfully created!.<br /><br /><a href="' . route('admin.articles.categories.edit', $category) . '">Click here</a> to view/edit the created article category.',
            'type' => 'success',
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
     * @param int $id
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

        if (request()->has('generate_slug') || !request()->filled('slug'))
        {
            $category->generateSlug();
            $category->save();
        }

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Article Category is successfully updated!.<br /><br /><a href="' . route('articles.get_category', $category->slug) . '">Click here</a> to view the updated article category.',
            'type' => 'success',
        ]);
    }

    public function toggleEnabled(Request $request, ArticleCategory $category)
    {
        $category->update([
            'enabled' => !$category->enabled,
        ]);

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Category Enabled state is successfully updated.<br/>New State: ' . (($category->enabled) ? 'Enabled' : 'Disabled'),
            'type' => 'success',
        ]);
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

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected Article Category is successfully deleted.',
            'type' => 'success',
        ]);
    }

    private function validateCategory()
    {
        request()->validate([
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate_slug' => ['sometimes', 'boolean'],
            'name' => ['required', 'string'],
            'enabled' => ['required', 'boolean'],
        ]);
    }
}
