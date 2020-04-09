<div class="form-group">
    <label>Mode</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="mode_true" class="custom-control-input" type="radio" v-model="mode" value="1">
            <label for="mode_true" class="custom-control-label">Simple</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="mode_false" class="custom-control-input" type="radio" v-model="mode" value="0">
            <label for="mode_false" class="custom-control-label">Advanced</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="name">Name</label>
    {{ Form::text('name', null, ['class' => 'form-control', 'required', 'v-model' => 'name', 'id' => 'name']) }}
</div>
<div class="form-group">
    <label for="categories">Categories</label>
    <select id="categories" class="form-control select2" name="categories[]" multiple="multiple" v-model="categories" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group" v-show="mode == 0">
    <label for="description">Description</label>
    {{ Form::text('description', null, ['class' => 'form-control', 'v-model' => 'description', 'id' => 'description']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label for="image">Image URL</label>
    {{ Form::text('image', null, ['class' => 'form-control', 'v-model.trim' => 'image', 'id' => 'image']) }}
</div>
<div class="form-group">
    <label for="payment_type">Payment Type</label>
    <select class="custom-select" name="payment_type" v-model="payment_type" id="payment_type" required>
        <option value="1">Balance</option>
        <option value="2">Balance (Point)</option>
        <option value="3">Silk</option>
        <option value="4">Silk (Gift)</option>
        <option value="5">Silk (Point)</option>
    </select>
</div>
<div class="form-group">
    <label for="price">Price</label>
    {{ Form::text('price', null, ['class' => 'form-control', 'required', 'v-model.trim' => 'price', 'id' => 'price']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label>On Sale</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="on_sale_true" class="custom-control-input" type="radio" v-model="on_sale" value="1">
            <label for="on_sale_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="on_sale_false" class="custom-control-input" type="radio" v-model="on_sale" value="0">
            <label for="on_sale_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="on_sale == 1 && mode == 0">
    <label for="price_before">Old Price</label>
    {{ Form::text('price_before', null, ['class' => 'form-control', 'v-model.trim' => 'price_before', 'id' => 'price_before']) }}
    <span class="form-text text-muted">
        Only effects visually.
    </span>
</div>
<div class="form-group" v-show="mode == 0">
    <label>Limit Total Purchases</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="limit_total_purchases_true" class="custom-control-input" type="radio" v-model="limit_total_purchases" value="1">
            <label for="limit_total_purchases_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="limit_total_purchases_false" class="custom-control-input" type="radio" v-model="limit_total_purchases" value="0">
            <label for="limit_total_purchases_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="limit_total_purchases == 1 && mode == 0">
    <label for="total_purchase_limit">Total Purchase Limit</label>
    {{ Form::text('total_purchase_limit', null, ['class' => 'form-control', 'v-model.trim' => 'total_purchase_limit', 'id' => 'total_purchase_limit']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label>Limit User Purchases</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="limit_user_purchases_true" class="custom-control-input" type="radio" v-model="limit_user_purchases" value="1">
            <label for="limit_user_purchases_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="limit_user_purchases_false" class="custom-control-input" type="radio" v-model="limit_user_purchases" value="0">
            <label for="limit_user_purchases_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="limit_user_purchases == 1 && mode == 0">
    <label for="user_purchase_limit">User Purchase Limit</label>
    {{ Form::text('user_purchase_limit', null, ['class' => 'form-control', 'v-model.trim' => 'user_purchase_limit', 'id' => 'user_purchase_limit']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label>Use Customized Referral Options</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="use_customized_referral_options_true" class="custom-control-input" type="radio" v-model="use_customized_referral_options" value="1">
            <label for="use_customized_referral_options_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="use_customized_referral_options_false" class="custom-control-input" type="radio" v-model="use_customized_referral_options" value="0">
            <label for="use_customized_referral_options_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="use_customized_referral_options == 1 && mode == 0">
    <label>Referral Commission</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="referral_commission_enabled_true" class="custom-control-input" type="radio" v-model="referral_commission_enabled" value="1">
            <label for="referral_commission_enabled_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="referral_commission_enabled_false" class="custom-control-input" type="radio" v-model="referral_commission_enabled" value="0">
            <label for="referral_commission_enabled_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="use_customized_referral_options == 1 && referral_commission_enabled == 1 && mode == 0">
    <label for="referral_commission_reward_type">Referral Commission Reward Type</label>
    <select class="form-control select2" name="referral_commission_reward_type" id="referral_commission_reward_type" data-placeholder="Select a reward type" v-model="referral_commission_reward_type">
        <option value="1">Balance</option>
        <option value="2">Balance (Point)</option>
        <option value="3">Silk</option>
        <option value="4">Silk (Gift)</option>
        <option value="5">Silk (Point)</option>
    </select>
</div>
<div class="form-group" v-show="use_customized_referral_options == 1 && referral_commission_enabled == 1 && mode == 0">
    <label for="referral_commission_percentage">Referral Commission Reward Percentage</label>
    {{ Form::text('referral_commission_percentage', null, ['class' => 'form-control', 'v-model.trim' => 'referral_commission_percentage', 'id' => 'referral_commission_percentage']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label>Use Customized Point Options</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="use_customized_point_options_true" class="custom-control-input" type="radio" v-model="use_customized_point_options" value="1">
            <label for="use_customized_point_options_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="use_customized_point_options_false" class="custom-control-input" type="radio" v-model="use_customized_point_options" value="0">
            <label for="use_customized_point_options_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="use_customized_point_options == 1 && mode == 0">
    <label>Reward for Purchase</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="reward_point_enabled_true" class="custom-control-input" type="radio" v-model="reward_point_enabled" value="1">
            <label for="reward_point_enabled_true" class="custom-control-label">Enabled</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="reward_point_enabled_false" class="custom-control-input" type="radio" v-model="reward_point_enabled" value="0">
            <label for="reward_point_enabled_false" class="custom-control-label">Disabled</label>
        </div>
    </div>
</div>
<div class="form-group" v-show="use_customized_point_options == 1 && reward_point_enabled == 1 && mode == 0">
    <label for="reward_point_type">Reward Type</label>
    <select class="custom-select" name="reward_point_type" v-model="reward_point_type" id="reward_point_type">
        <option value="1">Balance</option>
        <option value="2">Balance (Point)</option>
        <option value="3">Silk</option>
        <option value="4">Silk (Gift)</option>
        <option value="5">Silk (Point)</option>
    </select>
</div>
<div class="form-group" v-show="use_customized_point_options == 1 && reward_point_enabled == 1 && mode == 0">
    <label for="reward_point_percentage">Reward Percentage</label>
    {{ Form::text('reward_point_percentage', null, ['class' => 'form-control', 'v-model.trim' => 'reward_point_percentage', 'id' => 'reward_point_percentage']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label>Featured</label>
    <div class="row col-12">
        <div class="custom-control custom-radio custom-control-inline">
            <input id="featured_true" class="custom-control-input" type="radio" v-model="featured" value="1">
            <label for="featured_true" class="custom-control-label">Yes</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input id="featured_false" class="custom-control-input" type="radio" v-model="featured" value="0">
            <label for="featured_false" class="custom-control-label">No</label>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="order">Sort Order</label>
    {{ Form::text('order', null, ['class' => 'form-control', 'v-model.trim' => 'order', 'id' => 'order']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label for="available_after">Available After</label>
    {{ Form::text('available_after', null, ['class' => 'form-control flatpickr', 'v-model.trim' => 'available_after', 'id' => 'available_after']) }}
</div>
<div class="form-group" v-show="mode == 0">
    <label for="available_until">Available Until</label>
    {{ Form::text('available_until', null, ['class' => 'form-control flatpickr', 'v-model.trim' => 'available_until', 'id' => 'available_until']) }}
</div>
<div class="form-group">
    <label>Status</label>
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
