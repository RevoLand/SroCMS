@extends('layout')

@section('content')
<article class="news_row">
    <div class="news_head">
        <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}" class="top">{{ $article->title }}</a>
    </div>
    <section class="body">
        @if ($article->user->gravatar)
        <div class="avatar">
            <img src="{{ $article->user->gravatar }}" alt="avatar" height="120" width="120">
        </div>
        @endif

        {!! $article->content !!}

        <div class="clear"></div>

        <div class="post_info">
        <p>Posted by <a href="{{ route('users.show_user', $article->user) }}" data-tip="View profile"> {{ $article->user->getName() }}</a> on {{ $article->published_at ?? $article->updated_at }}</p>
            <span>
                @if ($article->article_comments_count > 0)
                <a href="#" class="comments_button">
                    Comments ({{ $article->article_comments_count }})
                </a>
                @endif
            </span>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>

        <div class="comments_area">
            @forelse ($articleComments as $comment)
                <div class="comment">
                    <div class="comment_date">{{ $comment->created_at }}</div>
                    <a href="{{ route('users.show_user', $comment->user) }}" data-tip="View profile>
                        <img src="{{ $comment->user->gravatar }}" height="44" width="44">
                    </a>
                    <a class="comment_author" href="{{ route('users.show_user', $comment->user) }}" data-tip="View profile"> {{ $comment->user->getName() }}</a>
                    {{ $comment->content }}
                    <div class="clear"></div>
                </div>
            @empty
                Bu yazıya herhangi bir yorum yapılmadı.
            @endforelse
        </div>

        @if (Auth::check())
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @can ('post comment')
            {{ Form::open(['route' => ['articles.store_comment', $article->id, $article->slug], 'method' => 'POST']) }}
                <textarea name="comment" spellcheck="false" placeholder="Type a comment..." maxlength="255"></textarea>
                <input type="submit" value="Submit comment" />
            {{ Form::close() }}
        @else
            <textarea disabled placeholder="Yorum yapma yetkiniz bulunmamaktadır."></textarea>
            <input type="submit" disabled="disabled" value="Submit comment"/>
        @endcan
        @else
            <textarea disabled placeholder="Yorum yapmak için lütfen giriş yapın."></textarea>
            <input type="submit" disabled="disabled" value="Submit comment"/>
        @endif
    <div class="clear"></div>
        {{ $articleComments->links() }}
    </section>
</article>
@endsection
