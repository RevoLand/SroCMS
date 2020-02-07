@extends ('layout')

@section ('contenttitle')
Haberler
@endsection

@section ('pagetitle')
Haberler
@endsection

@section ('content')
@foreach ($articles as $article)
<div class="row">
	<div class="col-md-12">
        <div class="article shadow-sm border rounded-sm px-3 pb-5 mb-2" role="article">
            <h2 class="article-title py-2">
                <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}">{{ $article->title }}</a>
            </h2>
            <div class="article-meta">
                <p class="text-muted">
                    <a data-toggle="tooltip" data-placement="bottom" title="{{ $article->published_at ?? $article->updated_at }}">{{ ($article->published_at) ? $article->published_at->diffForHumans() : $article->updated_at->diffForHumans() }}</a> by <a href="{{ route('users.show_user', $article->user) }}"> {{ $article->user->getName() }}</a>
                </p>
            </div>
            <div class="article-body">
                @if ($article->user->gravatar)
                    <img src="{{ $article->user->gravatar }}?s=120" class="article-user-avatar img-thumbnail rounded float-left mr-2" height="120" width="120">
                @endif

                <p>
                    {{ Str::limit($article->content, 450) }}
                </p>
                <div class="article-links">
                    <div class="float-left">
                        <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}#comments" class="badge badge-info shadow-sm">
                            Comments ({{ $article->article_comments_count }})
                        </a>
                    </div>
                    @if (mb_strlen($article->content, 'utf8') > 450)
                    <div class="float-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('articles.show_article', [$article->id, $article->slug]) }}">
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
{{ $articles->links() }}
@endsection
