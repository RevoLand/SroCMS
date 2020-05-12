@extends('layout')

@section('withsidebar', true)

@section('pagetitle')
    @isset ($category)
    Kategori: {{ $category->name }}
    @else
    Haberler
    @endisset
@endsection

@section('contenttitle')
    @isset ($category)
    Kategori: {{ $category->name }}
    @else
    Haberler
    @endisset
@endsection

@section('content')
<div class="articles">
    @forelse ($articles as $article)
    <div class="row">
        <div class="col-12">
            <div class="article bg-dark shadow-sm rounded px-3 py-2 mb-4" role="article">
                <h2 class="article-title py-2">
                    <a href="{{ route('articles.show_article', [$article->slug]) }}">{{ $article->title }}</a>
                </h2>
                <div class="article-meta my-2 py-2 border-bottom border-dark">
                    <div class="text-muted d-flex align-items-center justify-content-between">
                        <div>
                        <a data-toggle="tooltip" data-placement="bottom" title="{{ $article->published_at ?? $article->updated_at }}">
                            {{ ($article->published_at) ? $article->published_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans() : $article->updated_at->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans() }}
                        </a>
                        by <a href="{{ route('users.show_user', $article->user) }}">
                            {{ $article->user->getName() }}
                        </a>
                    </div>

                        <a href="{{ route('articles.show_article', [$article->slug]) }}#comments" class="btn btn-sm btn-secondary shadow-sm">
                            Comments ({{ $article->article_comments_count ?? $article->articleComments->count() }})
                        </a>
                    </div>
                </div>
                <div class="article-body">
                    <p>
                        @isset($article->excerpt)
                            {!! $article->excerpt !!}
                        @else
                            {!! $article->content !!}
                        @endisset
                    </p>
                    <div class="article-links">
                        @isset($article->excerpt)
                        <div class="float-right">
                            <a class="btn btn-block btn-primary" href="{{ route('articles.show_article', [$article->slug]) }}">
                                Devamını Oku...
                            </a>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="row">
        <div class="col-12">
            <div class="article bg-dark shadow-sm rounded px-3 pb-5 mb-2" role="article">
                Herhangi bir haber bulunamadı.
            </div>
        </div>
    </div>
    @endforelse
    <div class="articles-pagination-links">
        {{ $articles->links() }}
    </div>
</div>
@endsection
