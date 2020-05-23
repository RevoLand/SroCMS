@isset($model->guild)
{{-- TODO: Guild profile? --}}
<a class="text-reset text-wrap" href="#!">
    {{ $model->guild->Name }} ({{ $model->guild->Lvl }} Level)
</a>
@else
-
@endisset
