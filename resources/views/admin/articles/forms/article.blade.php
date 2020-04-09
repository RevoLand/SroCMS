<div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" v-model="title" required>
    <div class="custom-control custom-checkbox">
        <input id="generate_slug" class="custom-control-input" type="checkbox" true-value="1" false-value="0" v-model="generate_slug">
        <label for="generate_slug" class="custom-control-label">Auto Generate Slug from Title</label>
    </div>
</div>
<div class="form-group" v-show="generate_slug == 0">
    <label for="slug">Slug</label>
    <input id="slug" type="text" class="form-control" v-model="slug">
</div>
<div class="form-group">
    <label for="categories">Category</label>
    <select class="select2" id="categories" v-model="categories" multiple="multiple" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Excerpt (HTML)</label>
    <ckeditor :editor="editor" v-model="excerpt" :config="editorConfig"></ckeditor>
</div>
<div class="form-group">
    <label>Content (HTML)</label>
    <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
</div>
<div class="form-group">
    <label>Visibility</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="is_visible_true" class="custom-control-input" type="radio" v-model="is_visible" value="1">
            <label for="is_visible_true" class="custom-control-label">Visible</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="is_visible_false" class="custom-control-input" type="radio" v-model="is_visible" value="0">
            <label for="is_visible_false" class="custom-control-label">Hidden</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Comments</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="can_comment_on_true" class="custom-control-input" type="radio" v-model="can_comment_on" value="1">
            <label for="can_comment_on_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="can_comment_on_false" class="custom-control-input" type="radio" v-model="can_comment_on" value="0">
            <label for="can_comment_on_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>Published On</label>
    <input class="form-control flatpickr" type="datetime" id="published_at" v-model="published_at">
    <span for="published_at" class="form-text text-muted">When article will be published on? If set, article won't be accessable by users until the given time.</span>
</div>
