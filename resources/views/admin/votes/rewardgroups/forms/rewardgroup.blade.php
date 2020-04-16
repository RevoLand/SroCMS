<div class="form-group">
    <label>Vote Providers</label>
    <select class="form-control select2" multiple="multiple" v-model="form.vote_providers">
        @foreach($voteProviders as $voteProvider)
            <option value="{{ $voteProvider->id }}" >{{ $voteProvider->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" v-model="form.name" required>
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
