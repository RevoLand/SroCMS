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
            ->withCount(['articleComments' => function ($query)
                {
                    $query->visible()->approved();
                }, ])
            ->orderByDesc('updated_at')
            ->paginate(setting('articles.index.post_per_page', 5));

        return view('articles.index', compact('articles'));
    }

    public function show($id, $slug)
    {
        $article = Article::whereId($id)
            ->whereSlug($slug)
            ->published()
            ->with('user')
            ->withCount(['articleComments' => function ($query)
                {
                    $query->visible()->approved();
                }, ])
            ->firstOrFail();

        $articleComments = $article->articleComments()->visible()->approved()->latest()->with('user')->paginate(setting('article.comments.per_page', 20));

        return view('articles.single', compact('article', 'articleComments'));
    }
}
