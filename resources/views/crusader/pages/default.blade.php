@extends('layout')

@section('content')
<article>
    <h1 class="top">
        {{ $page->title }}<div></div>
    </h1>
    <section class="body">
        {!! $page->content !!}
    </section>
</article>
@endsection
