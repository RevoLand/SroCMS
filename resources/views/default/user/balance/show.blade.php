@extends('layout')

@section('pagetitle', 'Bakiye Bilgilerim')
@section('contenttitle', 'Bakiye Bilgilerim')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="user-balance bg-dark px-3 py-3 shadow-sm rounded-sm">
            <div class="row">
                <div class="col">
                    <table class="table table-responsive-md">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Önceki Bakiye</th>
                                <th scope="col">Yeni Bakiye</th>
                                <th scope="col">Fark</th>
                                <th scope="col">Bakiye Türü</th>
                                <th scope="col">Kaynak</th>
                                <th scope="col">Kaynak</th>
                                <th scope="col">Tarih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($balanceLogs as $balanceLog)
                            <tr>
                                <th scope="row">{{ $balanceLog->id }}</th>
                                <td>{{ number_format($balanceLog->balance_before, 2) }}</td>
                                <td>{{ number_format($balanceLog->balance_after, 2) }}</td>
                                <td>{{ number_format($balanceLog->balance_difference, 2) }}</td>
                                <td>{{ config('constants.balance.type_by_id.' . $balanceLog->balance_type) }}</td>
                                <td>{{ config('constants.balance.source_desc.' . $balanceLog->source) }}</td>
                                <td>@if($balanceLog->sourceUser) <a href="{{ route('users.show_user', $balanceLog->sourceUser->JID) }}">{{ $balanceLog->sourceUser->getName() }}</a>@else - @endif</td>
                                <td>{{ $balanceLog->created_at }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">Herhangi bir kayıt bulunamadı.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="8" scope="row">
                                    {{ $balanceLogs->links() }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
