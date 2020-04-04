@forelse($groupedPoints as $key => $groupedPoint)
{{ config('constants.payment_types.' . $key) }}: {{ $groupedPoint->sum->balance_difference }} @if (!$loop->last) <br/> @endif
@empty
    -
@endforelse
