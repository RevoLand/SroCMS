@extends('layout')

@section('withsidebar', true)

@section('pagetitle', 'Use E-Pin Code')

@section('contenttitle', 'Use E-Pin Code')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="epin-page bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            @include('components.forms.user.use_epin')
        </div>
    </div>
</div>
@endsection
