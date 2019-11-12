<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

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
            ->orderByDesc('updated_at')
            ->paginate(5);

        return view('articles.index', compact('articles'));
    }

    public function show($id, $slug)
    {
        return view('articles.single', ['article' => Article::where('id', $id)->where('slug', $slug)->firstOrFail()]);
    }
}
