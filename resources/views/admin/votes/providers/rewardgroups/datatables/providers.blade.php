@forelse ($model->voteproviders as $voteprovider)
<a href="{{ route('admin.votes.providers.show', $voteprovider) }}">
    <span class="kt-badge kt-badge--info kt-badge--inline">
        {{ $voteprovider->name }}
    </span>
</a>
@empty

@endforelse
