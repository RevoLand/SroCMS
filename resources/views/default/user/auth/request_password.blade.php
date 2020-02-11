@extends('layout')

@section('pagetitle', 'Şifrenizi mi unuttunuz?')
@section('contenttitle', 'Şifrenizi mi unuttunuz?')

@section('withsidebar', true)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-request-password bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if (session('status'))
                <ul class="alert alert-success">
                    <li>{{ Session::get('status') }}</li>
                </ul>
            @endif

            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="row">
                <div class="col">
                    <div class="password-request-form pb-3">
                        @include('components.forms.user.request_password')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
