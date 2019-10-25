<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ArticleCommentController extends Controller
{
    public function store($id, $slug, Request $request)
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:255']
        ]);

        $article = Article::where('id', $id)->where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if (!$user || !$article->is_visible || !$article->can_comment_on)
        {
            Alert::error('Hata!', 'Bu yazıya yorum yapamazsınız!');
            return redirect()->back();
        }

        $comment = new ArticleComment();
        $comment->article_id = $article->id;
        $comment->user_id = $user->JID;
        $comment->content = $request->comment;
        // TODO: Ayar tablosundan default ayarları al?
        $comment->is_visible = true;
        $comment->is_approved = true;
        // TODO: Ayar tablosundan default ayarları al?

        if ($comment->save())
        {
            Alert::success('Başarılı!', 'Yorumunuz kaydedildi.');
        }
        else
        {
            Alert::warning('Hata!', 'Yorumunuz kaydedilirken bir hata oluştu.');
        }

        return redirect()->back();
    }
}
