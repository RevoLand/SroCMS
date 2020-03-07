@foreach ($model->articleCategories as $category)
<a class="badge badge-info" href="{{ route('admin.articles.index', ['category_id' => $category->id]) }}">
    {{ $category->name }}
</a>
@endforeach
