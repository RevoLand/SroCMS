@extends('layout')

@section('pagetitle', 'Şifrenizi Güncelleyin')
@section('contenttitle', 'Şifrenizi Güncelleyin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-reset-password bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <div class="row">
                <div class="col">
                    <div class="password-reset-form pb-3">
                        @include('components.forms.user.reset_password')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
