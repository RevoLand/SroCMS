@extends('layout')

@section('pagetitle', 'Edit E-Pin')

@section('content')
<div class="card mb-3" id="content">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit E-Pin</h5>
        <div>
            <a class="btn btn-falcon-info" href="{{ route('admin.epins.index') }}">E-Pins</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                {{ Form::open(['route' => ['admin.epins.update', $epin], 'method' => 'patch', '@submit.prevent' => 'submitForm', '@change' => 'form.errors.clear($event.target.name)', 'class' => 'form-validation']) }}
                <div class="form-group">
                    <label>Code</label>
                    <input type="text" class="form-control" id="code" v-model="form.code">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="regenerate_code" v-model="form.regenerate_code" true-value="1" false-value="0"/>
                        <label for="regenerate_code" class="custom-control-label">Re-Generate Code</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Reward Type</label>
                    <select class="custom-select" id="type" name="type" v-model="form.type" required>
                        <option value="1">Balance</option>
                        <option value="2">Balance (Point)</option>
                        <option value="3">Silk</option>
                        <option value="4">Silk (Gift)</option>
                        <option value="5">Silk (Point)</option>
                        <option value="6">Item</option>
                    </select>
                </div>
                <div class="form-group" v-show="form.type != 6">
                    <label><template v-if="form.type < 3">Balance</template><template v-else>Amount</template></label>
                    <input type="text" class="form-control" id="balance" v-model="form.balance">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="enabled_true" v-model="form.enabled" value="1"/>
                            <label for="enabled_true" class="custom-control-label">Enabled</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="enabled_false" v-model="form.enabled" value="0"/>
                            <label for="enabled_false" class="custom-control-label">Disabled</label>
                        </div>
                    </div>
                </div>
                <div class="btn-group" role="group">
                    <button type="submit" class="btn btn-falcon-primary mr-2">Save</button>
                    {{ Form::close() }}
                    {!! Form::open([ 'route' => ['admin.epins.destroy', $epin], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
                        <button type="submit" class="btn btn-falcon-danger">Delete</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-deck" id="vue_items" v-show="show_items_form">
    <div class="card">
        <div class="card-header">
            E-Pin Items
        </div>
        <div class="card-body">
            <select class="custom-select" id="type" name="type" size="10" v-model="selecteditem">
                <option value="" v-show="false"></option>
                <option :value="{
                    epin_id: {{ $epin->id }},
                    amount: 1,
                    plus: 0
                }">Create New Item</option>
                <optgroup label="Existing Items">
                    <option v-for="item in items" :value="item">
                        [@{{ item.amount }}] @{{ item.codename }} (+@{{ item.plus }})
                    </option>
                </optgroup>
            </select>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <template v-if="selecteditem.id">
                Edit Item
            </template>
            <template v-else>
                Create Item
            </template>
        </div>
        <div class="card-body">
            <item_form v-bind:item="selecteditem"></item_form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    Vue.component('item_form', {
        props: ['item'],
        data: function() {
            return {
                IsBeingUpdated: false,
                IsBeingDeleted: false
            }
        },
        computed: {
            IsItCreateForm: function () {
                return !(this.item.id);
            }
        },
        template: `
            <div>
                <form method="post" v-bind:action="this.$root.update_action" @submit.prevent="updateItem">
                    <div class="form-group">
                        <label>Codename</label>
                        <input class="form-control" v-model="item.codename" required>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input class="form-control" v-model="item.amount" required>
                    </div>
                    <div class="form-group">
                        <label>Plus</label>
                        <input class="form-control" v-model="item.plus" required>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary" :disabled="IsBeingUpdated">
                                        <template v-if="IsItCreateForm">
                                        Create
                                        </template>
                                        <template v-else>
                                        Update
                                        </template>
                                    </button>
                                    <button type="button" class="btn btn-danger" @click="deleteItem(item)" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        `,
        methods: {
            updateItem(event) {
                $('.content').block();
                this.IsBeingUpdated = true;

                axios.post(event.target.action, this.item)
                .then(response => {
                    if (this.IsItCreateForm) {
                        this.$root.items.push(response.data.epinItem);
                    }

                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    });
                })
                .catch(error => {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';
                    swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                    this.IsBeingUpdated = false;
                });
            },

            deleteItem(itemToDelete) {
                $('.content').block();
                this.IsBeingDeleted = true;

                axios.post(this.$root.destroy_action, {
                    id: this.item.id
                })
                .then(response => {
                    this.$root.items.splice(this.$root.items.indexOf(itemToDelete), 1);
                    this.$root.selecteditem = '';
                    this.IsBeingDeleted = false;
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        icon: response.data.icon
                    });
                })
                .catch(error => {
                    var errors = '<ul class="list-unstyled">';
                    jQuery.each(error.response.data.errors, function (key, value) {
                        errors += '<li>';
                        errors += value;
                        errors += '</li>';
                    });
                    errors += '</ul>';
                    swal.fire({
                        icon: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    $('.content').unblock();
                    this.IsBeingDeleted = false;
                });
            }
        }
    });

    var vue = new Vue({
        el: '#content',
        data: {
            form: new Form({
                code: @json($epin->code),
                type: @json($epin->type),
                balance: @json($epin->balance),
                enabled: @json($epin->enabled),
                regenerate_code: 0
            })
        },
        methods: {
            submitForm() {
                this.form.patch(event.target.action)
                .then(response => {
                    this.form.code = response.epin.code;
                });
            },
            deleteForm(event) {
                this.form.delete(event.target.action)
                .then(response => {
                    window.location.href = '{{ route('admin.epins.index') }}'
                });
            }
        }
    });

    new Vue({
        el: '#vue_items',

        data: {
            items: [],
            selecteditem: '',
            update_action: @json(route('admin.epins.items.update')),
            destroy_action: @json(route('admin.epins.items.destroy'))
        },

        computed: {
            show_items_form: function () {
                return (vue.type == 6)
            }
        },

        mounted() {
            this.items = @json($epin->items)
        }
    });
</script>
@endsection
