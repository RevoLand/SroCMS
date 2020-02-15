@extends('layout')

@section('pagetitle', 'Karakter Görüntüle: ' . $character->CharName16)
@section('contenttitle', 'Karakter Görüntüle: ' . $character->CharName16)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="character-info bg-dark px-3 py-3 shadow-sm rounded-sm">
            {{-- Character image, name, stats --}}
            <div class="row">
                <div class="col-12 col-md-2">
                    <img class="img-fluid rounded-sm" alt="{{ $character->CharName16 }}" src="{{ Theme::url('img/silkroad/characters/' . $character->RefObjID . '.gif') }}">
                </div>
                <div class="col-12 col-md-10 mt-2 mt-md-0">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>{{ $character->CharName16 }}@if ($character->guild)<small class="text-muted ml-2">- <a class="text-info" href="{{ route('users.guilds.show', $character->guild) }}">{{ $character->guild->Name }}</a></small>@endif</h3>
                            <div class="level-info text-muted">
                                {{ $character->CurLevel  }} Level
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="user-stats">
                                <div class="progress shadow-sm rounded-0" style="height: 35px;">
                                    <div class="progress-bar bg-danger font-weight-bold" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Health: {{ number_format($character->HP) }}</div>
                                </div>
                                <div class="progress shadow-sm rounded-0 mt-2" style="height: 35px;">
                                    <div class="progress-bar bg-primary font-weight-bold" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Mana: {{ number_format($character->MP) }}</div>
                                </div>
                                <div class="progress shadow-sm rounded-0 mt-2" style="height: 35px;">
                                    <div class="progress-bar bg-success font-weight-bold" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Strength: {{ number_format($character->Strength) }}</div>
                                </div>
                                <div class="progress shadow-sm rounded-0 mt-2" style="height: 35px;">
                                    <div class="progress-bar bg-info font-weight-bold" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Intellect: {{ number_format($character->Intellect) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Character skill mastery info  --}}
            <div class="row mt-2 border-top border-secondary mt-3 pt-3">
                <div class="col">
                    Selam.
                </div>
                <div class="col">
                    <div class="card rounded-sm border-secondary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Skill Mastery</h5>
                            <div class="card-text">
                                @foreach ($character->skillMastery as $mastery)
                                <span>
                                    <img class="img-fluid" src="{{ Theme::url('img/silkroad/skills/masteries/' . $mastery->MasteryID . '.png') }}" width="16" height="16">
                                    <small class="text-muted">{{ config('constants.skillmastery.names.' . $mastery->MasteryID) }}</small>
                                </span>
                                <div class="progress rounded-0" style="height: 20px;">
                                    <div class="progress-bar @if((round($mastery->Level * 100 / setting('skillmastery.maxlevel', 110)) == 100)) bg-success @else bg-light @endif" style="width: {{ round($mastery->Level * 100 / setting('skillmastery.maxlevel', 110)) }}%" role="progressbar" aria-valuenow="{{ $mastery->Level }}" aria-valuemin="0" aria-valuemax="{{ setting('skillmastery.maxlevel', 110) }}">
                                        {{ $mastery->Level }}/{{ setting('skillmastery.maxlevel', 110) }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Character inventory --}}
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="inventoryTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" id="inventory-tab" data-toggle="tab" href="#inventory" role="tab" aria-controls="inventory" aria-selected="true">Envanter</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="avatar-inventory-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar" aria-selected="false">Avatar Envanteri</a>
                        </li>
                      </ul>
                      <div class="tab-content" id="inventoryTabContent">
                        <div class="tab-pane fade show active" id="inventory" role="tabpanel" aria-labelledby="inventory-tab">
                            <div class="row row-cols-2">
                                @foreach ($character->inventory as $inventoryItem)
                                <div class="col mb-2 pt-2 item-info">
                                    <img data-toggle="tooltip" data-html="true" data-placement="right" title='@include('components.items.tooltip', ['item' => $inventoryItem->item])' class="img-thumbnail mr-1" src="{{ $inventoryItem->item->objCommon->image }}">({{ $inventoryItem->Slot }}) {{ $inventoryItem->item->objCommon->CodeName128 }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-inventory-tab">
                            <div class="row row-cols-2">
                                @foreach ($character->inventoryForAvatar as $inventoryItem)
                                <div class="col mb-2 pt-2">
                                    <img class="img-thumbnail mr-1" src="{{ $inventoryItem->item->objCommon->image }}">({{ $inventoryItem->Slot }}) {{ $inventoryItem->item->objCommon->CodeName128 }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
