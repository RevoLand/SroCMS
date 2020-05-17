<div class="d-flex flex-wrap">
    @foreach ($model->categories as $category)
        <a class="badge @if ($category->enabled) badge-soft-primary @else badge-soft-danger @endif mt-1 rounded-lg" href="{{ route('admin.itemmall.categories.edit', $category) }}">{{ $category->name }}</a>
    @endforeach
</div>
