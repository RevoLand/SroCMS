@extends ('layout')

@section ('content')
<article>
    <h1 class="top">Bakiye Hareketleri</h1>
    <section class="body">
        <table width="100%" class="unstriped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Önceki Bakiye</th>
                    <th>Yeni Bakiye</th>
                    <th>Fark</th>
                    <th>Bakiye Türü</th>
                    <th>Kaynak</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($balanceLogs as $balanceLog)
                <tr>
                    <td>{{ $balanceLog->id }}</td>
                    <td>{{ number_format($balanceLog->balance_before, 2) }}</td>
                    <td>{{ number_format($balanceLog->balance_after, 2) }}</td>
                    <td>{{ number_format($balanceLog->balance_difference, 2) }}</td>
                    <td>{{ config('constants.balance.type_by_id.' . $balanceLog->balance_type) }}</td>
                    <td>{{ config('constants.balance.source_desc.' . $balanceLog->source) }}</td>
                    <td>{{ $balanceLog->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Herhangi bir kayıt bulunamadı.</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">
                        {{ $balanceLogs->links() }}
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="ucp_divider"></div>

    </section>
</article>
@endsection
