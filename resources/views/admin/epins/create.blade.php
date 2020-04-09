@extends('layout')

@section('pagetitle', 'Create E-Pin')

@section('content')
<div class="card mb-3">
    <div class="card-header">
      <h5 class="mb-0">Edit E-Pin</h5>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.epins.store'], 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code" v-model="code" v-show="regenerate_code == 0">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="regenerate_code" v-model="regenerate_code" true-value="1" false-value="0"/>
                        <label for="regenerate_code" class="custom-control-label">Auto-Generate Code</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Reward Type</label>
                    <select class="custom-select" id="type" name="type" v-model="type" required>
                        <option value="1">Balance</option>
                        <option value="2">Balance (Point)</option>
                        <option value="3">Silk</option>
                        <option value="4">Silk (Gift)</option>
                        <option value="5">Silk (Point)</option>
                        <option value="6">Item</option>
                    </select>
                </div>
                <div class="form-group" v-show="type != 6">
                    <label><template v-if="type < 3">Balance</template><template v-else>Amount</template></label>
                    <input type="text" class="form-control" id="balance" v-model="balance">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="enabled_true" v-model="enabled" value="1"/>
                            <label for="enabled_true" class="custom-control-label">Enabled</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="enabled_false" v-model="enabled" value="0"/>
                            <label for="enabled_false" class="custom-control-label">Disabled</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-falcon-primary">Create</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script type="text/javascript">
    new Vue({
        el: '.content',
        data: {
            code: '',
            type: 1,
            balance: '',
            enabled: '1',
            regenerate_code: '1'
        },
        methods: {
            submitForm(event) {
                $('.content').block();
                axios.post(event.target.action, this.$data)
                .then(response => {
                    Object.assign(this.$data, response.data.epin);
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    });
                })
                .catch(function (error) {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';

                    swal.fire({
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                });
            }
        }
    });
</script>
@endsection
