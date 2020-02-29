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
            ->orderByDesc('articles.updated_at')
            ->paginate(5);

        $articles->load(['articleComments' => function ($query)
            {
                $query->visible()->approved();
            }, ]);

        return view('articles.index', compact('articles', 'articleCategory'));
    }
}
