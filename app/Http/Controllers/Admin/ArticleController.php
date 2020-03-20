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

        if (request()->has('generate-slug'))
        {
            $article->generateSlug();
            $article->save();
        }

        return redirect()->route('admin.articles.edit', $article)->with('message', 'Article successfully created.');
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

        if (request()->has('generate-slug') || is_null($article->slug))
        {
            $article->generateSlug();
            $article->save();
        }

        return redirect()->route('admin.articles.edit', $article)->with('message', 'Article is successfully updated.');
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

        if (request()->expectsJson())
        {
            return response()->json(['message' => 'Selected article is successfully deleted.']);
        }

        return redirect()->route('admin.articles.index')->with('message', 'Selected article is successfully deleted.');
    }

    private function validateArticle()
    {
        return request()->validate([
            'title' => ['required', 'string'],
            'slug' => ['sometimes', 'nullable', 'string'],
            'generate-slug' => ['sometimes', 'boolean'],
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
