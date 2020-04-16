<div class="form-group">
    <label>Name</label>
    <input id="name" type="text" class="form-control" v-bind:class="{ 'error': form.errors.has('name') }" v-model="form.name" required>
    <label class="error" for="name" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></label>
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
    <label>State</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="enabled_true" class="custom-control-input" type="radio" v-model="form.enabled" value="1">
            <label for="enabled_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="enabled_false" class="custom-control-input" type="radio" v-model="form.enabled" value="0">
            <label for="enabled_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
