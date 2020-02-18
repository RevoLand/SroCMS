@extends('layout')

@section('pagetitle', $page->title)
@section('contenttitle', $page->title)

@if ($page->showsidebar)
    @section('withsidebar', true)
@endif

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="pages-default bg-dark px-3 py-3 shadow-sm rounded-sm">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
