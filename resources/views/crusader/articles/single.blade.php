@extends ('layout')

@section ('content')
<article class="news_row">
    <div class="news_head">
        <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}" class="top">{{ $article->title }}</a>
    </div>
    <section class="body">
        @if ($article->User->gravatar)
        <div class="avatar">
            <img src="{{ $article->User->gravatar }}" alt="avatar" height="120" width="120">
        </div>
        @endif

        {{ $article->content }}

        <div class="clear"></div>

        <div class="post_info">
        <p>Posted by <a href="{{ route('users.show_user', $article->user) }}" data-tip="View profile"> {{ $article->user->getName() }}</a> on {{ $article->published_at ?? $article->updated_at }}</p>
            <span>
                @if ($article->articleComments->count() > 0)
                <a href="#" class="comments_button">
                    Comments ({{ $article->articleComments->count() }})
                </a>
                @endif
            </span>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>

        <div class="comments_area">
            @if ($article->articleComments->count() > 0)
                @foreach ($paginatedComments = $article->articleComments()->paginate(10) as $comment)
                    <div class="comment">
                        <div class="comment_date">{{ $comment->created_at }}</div>
                        <a href="{{ route('users.show_user', $comment->user) }}" data-tip="View profile>
                            <img src="{{ $comment->user->gravatar }}" height="44" width="44">
                        </a>
                        <a class="comment_author" href="{{ route('users.show_user', $comment->user) }}" data-tip="View profile"> {{ $comment->user->getName() }}</a>
                        {{ $comment->content }}
                        <div class="clear"></div>
                    </div>
                @endforeach
            @endif
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
        @can ('post comments')
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
        {{ $paginatedComments->links() }}
    </section>
</article>
@endsection
