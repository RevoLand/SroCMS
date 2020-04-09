<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" v-model="name" required>
</div>
<div class="form-group">
    <label for="url">URL</label>
    <input type="text" class="form-control" id="url" v-model="url" required>
    <span class="fs--1 text-monospace">
        The URL which user will be redirected to,
        <mark>https://silkroad-servers.com/index.php?a=in&u=sroland</mark> for example.<br />
        <strong>DO NOT INCLUDE USER PART IN THE URL!</strong>
    </span>
</div>
<div class="form-group">
    <label for="url_user_name">URL Username Attribute</label>
    <input type="text" class="form-control" id="url_user_name" v-model="url_user_name" required>
    <span class="fs--1 text-monospace">
        The Username attribute that vote provider is asking for; setting this option as
        '<mark>id</mark>' will result as:
        <mark>https://silkroad-servers.com/index.php?a=in&u=sroland<b>&id=GENERATED_USER_VOTE_SECRET</b></mark>
    </span>
</div>
<div class="form-group">
    <label for="callback_secret">Callback Secret</label>
    <input type="text" class="form-control" id="callback_secret" v-model="callback_secret" v-show="generate_callback_secret == 0">
    <div class="custom-control custom-checkbox">
        <input id="generate_callback_secret" type="checkbox" value="1" class="custom-control-input" v-model="generate_callback_secret">
        <label for="generate_callback_secret" class="custom-control-label">Auto Generate</label>
    </div>
</div>
<div class="form-group">
    <label for="callback_user_name">Callback Username Attribute</label>
    <input type="text" class="form-control" id="callback_user_name" v-model="callback_user_name" required>
    <span class="fs--1 text-monospace">The attribute name vote provider will be sent for callback which should represent what we have sent to the provider. For example if it is set to <mark>userid</mark>, we will try to get the <mark>GENERATED_USER_VOTE_SECRET</mark> from<mark>userid</mark> request.
    </span>
</div>
<div class="form-group">
    <label for="callback_success_name">Callback Success Attribute <i>*nullable</i></label>
    <input type="text" class="form-control" id="callback_success_name" v-model="callback_success_name">
    <span class="fs--1 text-monospace">
        The attribute name vote provider will be sent for callback which should represent if the vote
        succeed or not. For example if it is set to <mark>voted</mark>, we will use <mark>voted</mark>
        attribute from the request to detect if user has been voted or not.<br />
        * This is not required by all vote providers so it can be left empty.
    </span>
</div>
<div class="form-group">
    <label for="minutes_between_votes">Time Interval for Voting (minutes)</label>
    <input type="number" class="form-control" id="minutes_between_votes" v-model="minutes_between_votes" required>
    <span class="fs--1 text-monospace">Time needs to be passed after a successful vote before voting again.</span>
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
