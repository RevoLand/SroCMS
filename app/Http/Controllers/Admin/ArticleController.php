<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleCategory;
use App\DataTables\ArticlesDataTable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ArticlesDataTable $dataTable)
    {
        return $dataTable->render('articles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::enabled()->orderBy('name')->get();

        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateArticle();

        $article = Article::create([
            'title' => request('title'),
            'slug' => request('slug'),
            'content' => request('content'),
            'excerpt' => request('excerpt'),
            'is_visible' => request('is_visible'),
            'can_comment_on' => request('can_comment_on'),
            'published_at' => Carbon::parse(request('published_at')),
            'author_id' => auth()->user()->JID,
        ]);

        $article->articleCategories()->attach(request('categories'));

        if (request('generate_slug') == 1)
        {
            $article->generateSlug();
            $article->save();
        }

        return response()->json([
            'title' => 'Successfully created!',
            'message' => 'Article is successfully created.<br /><br /><a href="' . route('admin.articles.edit', $article) . '">Click here</a> to view/edit the created article.',
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $categories = ArticleCategory::enabled()->orderBy('name')->get();
        $selectedCategories = $article->articleCategories->pluck('id')->toArray();

        return view('articles.edit', compact('article', 'categories', 'selectedCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $this->validateArticle();

        $article->update([
            'title' => request('title'),
            'slug' => request('slug'),
            'excerpt' => request('excerpt'),
            'content' => request('content'),
            'is_visible' => request('is_visible'),
            'can_comment_on' => request('can_comment_on'),
            'published_at' => Carbon::parse(request('published_at')),
            'author_id' => auth()->user()->JID,
        ]);

        $article->articleCategories()->sync(request('categories'));

        if (request()->has('generate_slug') || !request()->filled('slug'))
        {
            $article->generateSlug();
            $article->save();
        }

        return response()->json([
            'title' => 'Updated!',
            'message' => 'Article is successfully updated!.<br /><br /><a href="' . route('articles.show_article', $article->slug) . '">Click here</a> to view the updated article.',
            'type' => 'success',
        ]);
    }

    public function toggleVisibility(Request $request, Article $article)
    {
        $article->update([
            'is_visible' => !$article->is_visible,
        ]);

        return response()->json(['message' => 'Visibility state has been successfully updated.']);
    }

    public function toggleComments(Request $request, Article $article)
    {
        $article->update([
            'can_comment_on' => !$article->can_comment_on,
        ]);

        return response()->json(['message' => 'Commentable state has been successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'title' => 'Deleted!',
            'message' => 'Selected article is successfully deleted.',
            'type' => 'success',
        ]);
    }

    private function validateArticle()
    {
        return request()->validate([
            'title' => ['required', 'string'],
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate_slug' => ['sometimes', 'boolean'],
            'excerpt' => ['sometimes', 'nullable', 'string'],
            'content' => ['required', 'string'],
            'author_id' => ['sometimes', 'integer', 'exists:App\User,JID'],
            'categories' => ['required', 'array', 'exists:App\ArticleCategory,id'],
            'is_visible' => ['required', 'boolean'],
            'can_comment_on' => ['required', 'boolean'],
            'published_at' => ['required', 'date'],
        ]);
    }
}
