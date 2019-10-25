<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_visible', true)
            ->where(function ($query) {
                $query->where('published_at', '=', NULL)
                    ->orWhere('published_at', '<=', Carbon::now());
            })
            ->paginate(5);

        return view('articles.index', compact('articles'));
    }

    public function show($id, $slug)
    {
        return view('articles.single', ['article' => Article::where('id', $id)->where('slug', $slug)->firstOrFail()]);
    }
}
