@extends ('layout')

@section ('contenttitle')
Haberler
@endsection

@section ('pagetitle')
Haberler
@endsection

@section ('content')
<div class="articles">
@foreach ($articles as $article)
<div class="row">
	<div class="col-md-12">
        <div class="article shadow-sm rounded px-3 pb-5 mb-2" role="article">
            <h2 class="article-title py-2">
                <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}">{{ $article->title }}</a>
            </h2>
            <div class="article-meta my-2 py-2 border-bottom border-dark">
                <div class="text-muted d-flex align-items-center justify-content-between">
                    <div>
                    <a data-toggle="tooltip" data-placement="bottom" title="{{ $article->published_at ?? $article->updated_at }}">
                        {{ ($article->published_at) ? $article->published_at->diffForHumans() : $article->updated_at->diffForHumans() }}
                    </a>
                    by <a href="{{ route('users.show_user', $article->user) }}">
                        {{ $article->user->getName() }}
                    </a>
                </div>

                    <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}#comments" class="btn btn-sm btn-secondary shadow-sm">
                        Comments ({{ $article->article_comments_count }})
                    </a>
                </div>
            </div>
            <div class="article-body">
                @if ($article->user->gravatar)
                <div class="article-avatar float-left px-2 pt-1 mr-2">
                    <img src="{{ $article->user->gravatar }}?s=120" class="article-user-avatar img-fluid rounded shadow" height="120" width="120">
                </div>
                @endif

                <p>
                    {{ Str::limit($article->content, 450) }}
                </p>
                <div class="article-links">
                    @if (mb_strlen($article->content, 'utf8') > 450)
                    <div class="float-right">
                        <a class="btn btn-block btn-primary" href="{{ route('articles.show_article', [$article->id, $article->slug]) }}">
                            Devamını Oku...
                        </a>
                    </div>
                    @endif
                </div>
            </div>
	    </div>
	</div>
</div>
@endforeach
<div class="articles-pagination-links">
    {{ $articles->links() }}
</div>
</div>
@endsection
