<?php

namespace App\Http\Controllers;

use App\ArticleCategory;

class ArticleCategoryController extends Controller
{
    public function show($slug)
    {
        $articleCategory = ArticleCategory::whereSlug($slug)->enabled()->firstOrFail();

        $articles = $articleCategory->articles()
            ->visible()
            ->published()
            ->with('user')
            ->withCount(['articleComments' => function ($query)
                {
                    $query->visible()->approved();
                }, ])
            ->orderByDesc('articles.updated_at')
            ->paginate(5);

        return view('articles.index', compact('articles', 'articleCategory'));
    }
}
