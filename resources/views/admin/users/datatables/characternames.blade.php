<div class="text-wrap">
@forelse($model->characternames as $character)
<a class="text-reset text-decoration-none" href="{{ route('admin.characters.show', $character->character) }}">{{ $character->character->CharName16 }}</a>
@if(!$loop->last), @endif
@empty
-
@endforelse
</div>
