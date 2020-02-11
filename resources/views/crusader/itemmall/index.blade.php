@extends('layout')

@section('content')
<article>
    <h1 class="top">
        Item Mall<div></div>
    </h1>
    <section class="body">
        @foreach ($itemMallCategories as $itemMallCategory)
            <h2><a>{{ $itemMallCategory->name }}</a></h2>
            @foreach ($itemMallCategory->itemGroupsEnabled as $itemGroup)
                <p>{{ $itemGroup->name }}</p>

                <hr />
            @endforeach
        @endforeach
    </section>
</article>

@endsection
