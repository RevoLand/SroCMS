@foreach ($model->categories as $category)
    <a class="btn btn-sm @if ($category->enabled) btn-primary @else btn-danger @endif mt-1 rounded-lg" href="{{ route('admin.itemmall.categories.edit', $category) }}">{{ $category->name }}</a>
@endforeach
