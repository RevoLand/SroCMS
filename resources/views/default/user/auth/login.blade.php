@extends('layout')

@section('pagetitle', 'Giriş')
@section('contenttitle', 'Giriş')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="user-login-page bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            {{-- Giriş formu --}}
            <div class="row">
                <div class="col">
                    <div class="login-form pb-3">
                        @include('components.forms.user.login')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
