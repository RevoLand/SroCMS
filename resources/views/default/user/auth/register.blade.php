@extends('layout')

@section('pagetitle', 'Kayıt')
@section('contenttitle', 'Kayıt')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="user-register-page bg-dark px-3 py-3 shadow-sm rounded-sm">
            @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            {{-- Kayıt formu --}}
            <div class="row">
                <div class="col">
                    <div class="register-form pb-3">
                        @include('components.forms.user.register')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
