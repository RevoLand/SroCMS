<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" v-model="form.title" required>
    <div class="custom-control custom-checkbox">
        <input id="generate_slug" class="custom-control-input" type="checkbox" true-value="1" false-value="0" v-model="form.generate_slug">
        <label for="generate_slug" class="custom-control-label">Auto Generate Slug from Title</label>
    </div>
</div>
<div class="form-group" v-show="form.generate_slug == 0">
    <label for="slug">Slug</label>
    <input id="slug" type="text" class="form-control" v-model="form.slug">
</div>
<div class="form-group">
    <label for="categories">Category</label>
    <select class="select2" id="categories" v-model="form.categories" multiple="multiple" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Excerpt (HTML)</label>
    <editor id="excerpt" :init="editorConfig" v-model="form.excerpt" />
</div>
<div class="form-group">
    <label>Content (HTML)</label>
    <editor id="content" :init="editorConfig" v-model="form.content" />
</div>
<div class="form-group">
    <label>Visibility</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="is_visible_true" class="custom-control-input" type="radio" v-model="form.is_visible" value="1">
            <label for="is_visible_true" class="custom-control-label">Visible</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="is_visible_false" class="custom-control-input" type="radio" v-model="form.is_visible" value="0">
            <label for="is_visible_false" class="custom-control-label">Hidden</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Comments</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="can_comment_on_true" class="custom-control-input" type="radio" v-model="form.can_comment_on" value="1">
            <label for="can_comment_on_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="can_comment_on_false" class="custom-control-input" type="radio" v-model="form.can_comment_on" value="0">
            <label for="can_comment_on_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Published On</label>
    <input class="form-control flatpickr" type="datetime" id="published_at" v-model="form.published_at">
    <span for="published_at" class="form-text text-muted">When article will be published on? If set, article won't be accessable by users until the given time.</span>
</div>
