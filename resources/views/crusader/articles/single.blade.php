@extends('layout')

@section('content')
<article class="news_row">
    <div class="news_head">
        <a href="{{ route('showArticle', [$article->id, $article->slug]) }}" class="top">{{ $article->title }}</a>
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
        <p>Posted by <a href="#" data-tip="View profile"> {{ $article->User->Name ?? $article->User->StrUserID }}</a> on {{ $article->published_at ?? $article->updated_at }}</p>
            <span>
                @if ($article->Comments->count() > 0)
                <a href="#" class="comments_button">
                    Comments ({{ $article->Comments->count() }})
                </a>
                @endif
            </span>
            <div class="clear"></div>
        </div>
        <div class="divider"></div>

        <div class="comments_area">
            @if ($article->Comments->count() > 0)
                @foreach ($paginatedComments = $article->Comments()->paginate(10) as $comment)
                    <div class="comment">
                        <div class="comment_date">{{ $comment->created_at }}</div>
                        <a href="#" data-tip="View profile>
                            <img src="{{ $comment->User->gravatar }}" height="44" width="44">
                        </a>
                        <a class="comment_author" href="#" data-tip="View profile"> {{ $comment->User->Name ?? $comment->User->StrUserID }}</a>
                        {{ $comment->content }}
                        <div class="clear"></div>
                    </div>
                @endforeach
            @endif
        </div>

        <form>
            @if (isset($User))
                <textarea spellcheck="false" {$field_id} placeholder="Type a comment..." onkeyup="UI.limitCharacters(this, 'characters_remaining_{$id}')" maxlength="255"></textarea>
                <div class="characters_remaining"><span id="characters_remaining_{$id}">0 / 255</span> characters</div>
                <input type="submit" value="Submit comment" id="comment_button_{$id}" />
            @else
                <textarea disabled placeholder="Please log in to comment"></textarea>
                <input type="submit" disabled="disabled" value="Submit comment"/>
            @endif
        </form>
        <div class="clear"></div>
        {{ $paginatedComments->links() }}
    </section>
</article>
@endsection
