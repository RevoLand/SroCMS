<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" v-model="name" required>
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
