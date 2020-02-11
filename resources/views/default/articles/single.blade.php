@extends ('layout')

@section ('withsidebar', true)

@section ('pagetitle')
{{ $article->title }}
@endsection

@section ('content')
<div class="row">
	<div class="col-md-12">
        <div class="article shadow-sm border rounded-sm px-3 pb-5 mb-2" role="article">
            <h2 class="article-title py-2">
                <a href="{{ route('articles.show_article', [$article->id, $article->slug]) }}">{{ $article->title }}</a>
            </h2>
            <div class="article-meta">
                <p class="text-muted font-italic">
                    {{ $article->articleCategory->title }}
                </p>
            </div>
            <div class="article-body">
                <p>
                    {!! $article->content !!}
                </p>
                <div class="article-comments">

                </div>
            </div>
	    </div>
        <div class="article-user card shadow-sm mb-2">
            <div class="row no-gutters">
                @if ($article->user->gravatar)
              <div class="col-md-3">
                <img src="{{ $article->user->gravatar }}?s=182" class="card-img">
              </div>
              @endif
              <div class="col-md-9">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('users.show_user', $article->user) }}"> {{ $article->user->getName() }}</a></h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted"><a data-toggle="tooltip" data-placement="bottom" title="{{ $article->published_at ?? $article->updated_at }}">{{ ($article->published_at) ? $article->published_at->diffForHumans() : $article->updated_at->diffForHumans() }}</a></small></p>
                </div>
              </div>
            </div>
        </div>
        <div class="article-comments border rounded shadow-sm px-3 py-3 mb-2">
            <div class="form-group">
                @auth
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    @can ('post comments')
                    {{ Form::open(['route' => ['articles.store_comment', $article->id, $article->slug], 'method' => 'POST']) }}
                        <label for="articleComment">Yorum yap:</label>
                        <textarea class="form-control" name="comment" id="articleComment" rows="3" minlength="1" maxlength="255"></textarea>
                        <button class="btn btn-primary btn-block my-1" type="submit">Gönder</button>
                    {{ Form::close() }}
                    @else
                        <textarea class="form-control" name="comment" id="articleComment" rows="3" minlength="1" maxlength="255" disabled placeholder="Yorum yapma yetkiniz bulunmamaktadır."></textarea>
                    @endcan
                @endauth
                @guest
                    <label for="articleComment">Yorum yap:</label>
                    <textarea class="form-control" name="comment" id="articleComment" rows="3" minlength="1" maxlength="255" disabled placeholder="Bu yazıya yorum yapabilmek için giriş yapmanız gerekmektedir."></textarea>
                @endguest
            </div>
            @foreach ($articleComments as $articleComment)
                @include('articles.comment', ['articleComment' => $articleComment])
            @endforeach
            <div class="mt-3">
                {{ $articleComments->links() }}
            </div>
        </div>
	</div>
</div>
@endsection
