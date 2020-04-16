<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" v-model="form.name" required>
</div>
<div class="form-group balance-selector">
    <label for="order">Sort Order</label>
    <input type="number" class="form-control" id="order" v-model="form.order" required>
</div>
<div class="form-group">
    <label>Status</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" id="enabled_true" v-model="form.enabled" value="1">
            <label for="enabled_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input class="custom-control-input" type="radio" id="enabled_false" v-model="form.enabled" value="0">
            <label for="enabled_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
