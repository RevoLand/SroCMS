@forelse ($model->voteproviders as $voteprovider)
<a class="badge bg-soft-primary rounded-lg" href="{{ route('admin.votes.providers.show', $voteprovider) }}">
    {{ $voteprovider->name }}
</a>
@empty
-
@endforelse
