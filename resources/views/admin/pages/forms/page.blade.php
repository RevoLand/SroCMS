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
    <label>Content</label>
    <ckeditor :editor="editor" v-model="content" :config="editorConfig"></ckeditor>
</div>
<div class="form-group">
    <label for="view">View</label>
    <input id="view" type="text" class="form-control" v-model="view">
    <span class="form-text text-muted">View will be showed rather than the content set.</span>
</div>
<div class="form-group">
    <label for="middleware">Middleware</label>
    <input id="middleware" type="text" class="form-control" v-model="middleware">
    <span class="form-text text-muted">Middleware required to access page.</span>
</div>
<div class="form-group">
    <label>Sidebar Visibility in Page</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="showsidebar_true" class="custom-control-input" type="radio" v-model="showsidebar" value="1">
            <label for="showsidebar_true" class="custom-control-label">Visible</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="showsidebar_false" class="custom-control-input" type="radio" v-model="showsidebar" value="0">
            <label for="showsidebar_false" class="custom-control-label">Hidden</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label>State</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="enabled_true" class="custom-control-input" type="radio" v-model="enabled" value="1">
            <label for="enabled_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="enabled_false" class="custom-control-input" type="radio" v-model="enabled" value="0">
            <label for="enabled_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
