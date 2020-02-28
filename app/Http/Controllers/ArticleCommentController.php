<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ArticleCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:5,1')->only('store');
        $this->middleware('permission:post comments');
    }

    public function store($id, $slug)
    {
        request()->validate([
            'comment' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        $article = Article::whereId($id)->whereSlug($slug)->firstOrFail();
        if (!$article->is_visible || !$article->can_comment_on)
        {
            Alert::error('Hata!', 'Bu yazıya yorum yapamazsınız!');

            return redirect()->back();
        }

        ArticleComment::create([
            'article_id' => $article->id,
            'user_id' => Auth::user()->JID,
            'content' => request('comment'),
            'is_visible' => setting('article.comments.default_is_visible', 1),
            'is_approved' => setting('article.comments.default_is_approved', 1),
        ]);

        Alert::success('Başarılı!', 'Yorumunuz kaydedildi.');

        return redirect()->back();
    }
}
