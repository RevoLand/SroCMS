@foreach ($model->articleCategories as $category)
<a class="badge badge-soft-info" href="{{ route('admin.articles.index', ['category_id' => $category->id]) }}">
    {{ $category->name }}
</a>
@endforeach
