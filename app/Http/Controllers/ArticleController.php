<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_visible', true)
            ->where(function ($query)
            {
                $query->where('published_at', '=', null)
                    ->orWhere('published_at', '<=', Carbon::now());
            })
            ->with('user')
            ->withCount('articleComments')
            ->orderByDesc('updated_at')
            ->paginate(5);

        return view('articles.index', compact('articles'));
    }

    public function show($id, $slug)
    {
        $article = Article::where('id', $id)
            ->where('slug', $slug)
            ->where(function ($query)
            {
                $query->where('published_at', '=', null)
                    ->orWhere('published_at', '<=', Carbon::now());
            })
            ->with('user')
            ->withCount('articleComments')
            ->firstOrFail();

        $articleComments = $article->articleComments()->with('user')->paginate(10);

        return view('articles.single', compact('article', 'articleComments'));
    }
}
