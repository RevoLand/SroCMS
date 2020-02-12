@extends('layout')

@section('withsidebar', true)

@section('pagetitle')
Kontrol Paneli: {{ auth()->user()->getName() }}
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="user-profile bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row border-bottom border-secondary shadow-sm mb-3 pb-3">
                @if (auth()->user()->gravatar)
                <div class="col-md-3">
                    <img src="{{ auth()->user()->gravatar }}?s=256" class="img-fluid shadow rounded-sm">
                </div>
                @endif
                <div class="col-12 col-md mt-3 mt-md-0">
                    <div class="groups float-right">
                        @forelse (auth()->user()->getRoleNames() as $userRole)
                            <span class="badge badge-danger">{{ $userRole }}</span>
                        @empty
                            <small class="text-muted">Üye herhangi bir yetki grubuna bağlı değil.</small>
                        @endforelse
                    </div>
                    <div class="title">
                        <h3 class="text-capitalize text-danger">{{ auth()->user()->getName() }}</h3>
                    </div>
                    <div class="details border rounded-sm border-secondary px-2 pt-2">
                        <div class="row">
                            <div class="col-md">
                                <ul class="list-unstyled">
                                    <li>
                                        Kayıt Tarihi:
                                        @if (auth()->user()->regtime)
                                            <div class="text-muted" data-toggle="tooltip" title="{{ auth()->user()->regtime }}">{{ auth()->user()->regtime->locale(env('APP_LOCALE', 'tr_TR'))->diffForHumans(['parts' => 3, 'short' => true]) }}</div>
                                        @else
                                            Yok.
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md">
                                <ul class="list-unstyled">
                                    @if (auth()->user()->referrer)
                                    <li>
                                        Refere eden:<br/><a href="{{ route('users.show_user', auth()->user()->referrer->referrerUser) }}">{{ auth()->user()->referrer->referrerUser->getName() }}</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pb-3">
                <div class="col-md">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <h4 class="card-title">Silk Bilgilerim</h4>
                            <ul class="card-text list-unstyled">
                                <li>{{ setting('silk.silk_own_name', 'Silk') }}:<br/>{{ number_format(auth()->user()->silk->silk_own) }}</li>
                                <li>{{ setting('silk.silk_gift_name', 'Silk (Gift)') }}:<br/>{{ number_format(auth()->user()->silk->silk_gift) }}</li>
                                <li>{{ setting('silk.silk_point_name', 'Silk (Point)') }}:<br/>{{ number_format(auth()->user()->silk->silk_point) }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <h4 class="card-title">Bakiye Bilgilerim</h4>
                            <ul class="card-text list-unstyled">
                                <li>{{ setting('balance.name', 'Bakiye') }}:<br/>{{ number_format(auth()->user()->balance->balance, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                                <li>{{ setting('balance.point_name', 'Bakiye (Puan)') }}:<br/>{{ number_format(auth()->user()->balance->balance_point, 2) }} {{ setting('balance.currency', 'TL') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @if (setting('referrals.enabled', 1))
                <div class="col-md">
                    <div class="card shadow-sm rounded-sm">
                        <div class="card-body">
                            <h4 class="card-title">Referanslarım <small class="text-muted">(Son 5)</small></h4>
                            <ul class="card-text list-unstyled">
                                @forelse(auth()->user()->referrals as $referral)
                                <li><a href="{{ route('users.show_user', $referral->user) }}">{{ $referral->user->getName() }}</a><br /><small class="text-muted">{{ $referral->created_at }}</small></li>
                                @empty
                                <li><small class="text-muted">Refere ettiğiniz herhangi bir kullanıcı bulunmamaktadır.</small></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="links mt-2 mb-4">
                        <a href="{{ route('users.edit_form') }}" class="btn btn-block btn-lg btn-danger">Ayarlar</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="characters d-md-flex">
                    @forelse(auth()->user()->characters as $character)
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
                            <small class="text-muted">Herhangi bir karakter bulunamadı.</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
