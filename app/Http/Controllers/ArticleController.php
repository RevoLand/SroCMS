<?php

namespace App\Http\Controllers;

use App\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::visible()
            ->published()
            ->with('user')
            ->withCount('articleComments')
            ->orderByDesc('updated_at')
            ->paginate(5);

        return view('articles.index', compact('articles'));
    }

    public function show($id, $slug)
    {
        $article = Article::whereId($id)
            ->whereSlug($slug)
            ->published()
            ->with('user')
            ->withCount('articleComments')
            ->firstOrFail();

        $articleComments = $article->articleComments()->visible()->approved()->latest()->with('user')->paginate(10);

        return view('articles.single', compact('article', 'articleComments'));
    }
}
