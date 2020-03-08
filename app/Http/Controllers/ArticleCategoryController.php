<?php

namespace App\Http\Controllers;

use App\ArticleCategory;

class ArticleCategoryController extends Controller
{
    public function show(ArticleCategory $category)
    {
        if (!$category->enabled)
        {
            return redirect()->route('articles.show_articles');
        }

        $articles = $category->articles()
            ->visible()
            ->published()
            ->with('user')
            ->orderByDesc('articles.updated_at')
            ->paginate(5);

        $articles->load(['articleComments' => function ($query)
            {
                $query->visible()->approved();
            }, ]);

        return view('articles.index', compact('articles', 'category'));
    }
}
