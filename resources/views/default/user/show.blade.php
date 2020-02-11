@extends('layout')

@section('withsidebar', true)

@section('pagetitle')
Kontrol Paneli: {{ $user->getName() }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-profile bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row border-bottom border-secondary shadow-sm mb-3 pb-3">
                @if ($user->gravatar)
                <div class="col-md-3">
                    <img src="{{ $user->gravatar }}?s=256" class="img-fluid shadow rounded-sm">
                </div>
                @endif
                <div class="col-12 col-md mt-3 mt-md-0">
                    <div class="groups float-right">
                        @forelse ($user->getRoleNames() as $userRole)
                            <span class="badge badge-danger">{{ $userRole }}</span>
                        @empty
                            <small class="text-muted">Üye herhangi bir yetki grubuna bağlı değil.</small>
                        @endforelse
                    </div>
                    <div class="title">
                        <h3 class="text-capitalize text-danger">{{ $user->getName() }}</h3>
                    </div>
                    <div class="details border rounded-sm border-secondary px-2 pt-2">
                        <div class="row">
                            <div class="col-md">
                                <ul class="list-unstyled">
                                    <li>
                                        Kayıt Tarihi:
                                        @if ($user->regtime)
                                            <div class="text-muted" data-toggle="tooltip" title="{{ $user->regtime }}">{{ $user->regtime->diffForHumans() }}</div>
                                        @else
                                            Yok.
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="characters d-md-flex">
                    @forelse($user->characters as $character)
                    <div class="col">
                        <figure class="figure">
                            <img class="figure-img img-fluid border-0 shadow-sm rounded" alt="{{ $character->CharName16 }}" src="{{ Theme::url('img/silkroad/characters/' . $character->RefObjID . '.gif') }}">
                            <figcaption class="figure-caption">
                                <a href="{{ route('users.characters.show', $character) }}" class="stretched-link">
                                {{ $character->CharName16 }} <small class="text-muted">- {{ $character->CurLevel }} Level</small>
                                </a>
                            </figcaption>
                        </figure>
                    </div>
                    @empty
                    <div class="col">
                        <small class="text-muted">Üyeye ait herhangi bir karakter bulunamadı.</small>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
