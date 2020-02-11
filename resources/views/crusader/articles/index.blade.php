@extends('layout')

@section('content')
@foreach ($articles as $article)
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

            {{ Str::limit($article->content, 250) }}

			<div class="clear"></div>

            <div class="post_info">
            <p>Posted by <a href="{{ route('users.show_user', $article->user) }}" data-tip="View profile"> {{ $article->user->getName() }}</a> on {{ $article->published_at ?? $article->updated_at }}</p>
                <span>
                    <a href="#" class="comments_button">
                        Comments ({{ $article->article_comments_count }})
                    </a>
                </span>
                <div class="clear"></div>
           	</div>
		</section>
	</article>
@endforeach

{{ $articles->links() }}

@endsection
