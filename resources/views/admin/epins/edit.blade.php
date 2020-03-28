@extends('layout')

@section('pagetitle', 'Edit E-Pin')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit E-Pin</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.epins.index') }}" class="kt-subheader__breadcrumbs-link">E-Pin System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.epins.edit', $epin) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid vuepicker">
        @if (session('message'))
        <div class="row">
            <div class="col">
                <div class="alert alert-light alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-check-square kt-font-brand"></i></div>
                    <div class="alert-text">
                        {{ session('message') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if ($errors->any())
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-elevate fade show" role="alert">
                    <div class="alert-icon"><i class="la la-warning kt-font-brand"></i></div>
                    <div class="alert-text">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Edit E-Pin
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.epins.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-edit"></i> Create E-Pin
                        </a>
                        <a href="{{ route('admin.epins.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List E-Pins
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.epins.update', $epin], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Code</label>
                        {{ Form::text('code', $epin->code, ['class' => 'form-control code-input']) }}
                        <br />
                        <label class="kt-checkbox">
                            {!! Form::checkbox('generate-code', 1, false) !!} Re-Generate Code
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Reward Type</label>
                        <select class="form-control" id="type" name="type" v-model="epin_reward_type" required>
                            <option value="1">Balance</option>
                            <option value="2">Balance (Point)</option>
                            <option value="3">Silk</option>
                            <option value="4">Silk (Gift)</option>
                            <option value="5">Silk (Point)</option>
                            <option value="6">Item</option>
                        </select>
                    </div>
                    <div class="form-group balance-selector">
                        <label>Balance / Amount</label>
                        {{ Form::text('balance', $epin->balance, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, $epin->enabled) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !$epin->enabled) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-form__actions--right">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col kt-align-right">
                                    {!! Form::open([ 'route' => ['admin.epins.destroy', $epin], 'method' => 'delete']) !!}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
        <div class="row vue_items" v-show="epin_reward_type == 6">
            <div class="col-xl-6">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon"><i class="flaticon-stopwatch"></i></span>
                            <h3 class="kt-portlet__head-title">E-Pin Items</h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content">
                            <select class="form-control" id="type" name="type" size="10" v-model="selecteditem">
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
                </div>

                <!--end::Portlet-->
            </div>
            <div class="col-xl-6" id="test" v-show="selecteditem">
                <!--begin::Portlet-->
                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selecteditem.id">
                                    Edit Item
                                </template>
                                <template v-else>
                                    Create Item
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <div class="kt-portlet__content" v-if="selecteditem">
                            <item_form v-bind:item="selecteditem"></item_form>
                        </div>
                    </div>
                </div>

                <!--end::Portlet-->
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection


@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
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
                KTApp.block('body');
                this.IsBeingUpdated = true;

                axios.post(event.target.action, this.item)
                .then(response => {
                    if (this.IsItCreateForm) {
                        this.$root.items.push(response.data.epinItem);
                        swal.fire( 'Created!', response.data.message, 'success');
                    } else {
                        swal.fire( 'Updated!', response.data.message, 'success');
                    }
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                    this.IsBeingUpdated = false;
                });
            },

            deleteItem(itemToDelete) {
                KTApp.block('body');
                this.IsBeingDeleted = true;

                axios.post(this.$root.destroy_action, {
                    id: this.item.id
                })
                .then(response => {
                    this.$root.items.splice(this.$root.items.indexOf(itemToDelete), 1);
                    this.$root.selecteditem = '';
                    this.IsBeingDeleted = false;
                    swal.fire( 'Deleted!', response.data.message, 'success');
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
                        type: 'error',
                        title: error.response.data.message,
                        html: errors
                    });
                })
                .finally(() => {
                    KTApp.unblock('body');
                    this.IsBeingDeleted = false;
                });
            }
        }
    });

    new Vue({
        el: '.vue_items',

        data: {
            items: [],
            epin_reward_type: '',
            selecteditem: '',
            update_action: '{{ route('admin.epins.items.update') }}',
            destroy_action: '{{ route('admin.epins.items.destroy') }}'
        },

        computed: {
            show_items_form: function () {
                return (this.epin_reward_type == 6)
            }
        },

        mounted() {
            this.items = @json($epin->items),
            this.epin_reward_type = {{ $epin->type }}
        }
    });

    $(document).ready(function() {

        function toggleFields(typeId) {
            if (typeId == '6') {
                $( ".balance-selector" ).hide({});
            } else {
                $( ".balance-selector" ).show({});
            }
        };

        function toggleCodeInput(checked) {
            if (checked){
                $('.code-input').hide({});
            } else {
                $('.code-input').show({});
            }
        }

        $( "#type" ).change(function() {
            toggleFields(this.value);
        });

        toggleFields('{{ $epin->type }}');

        var generateCodeCheckboxSelector = $( "input[name='generate-code']");

        generateCodeCheckboxSelector.click(function() {
            toggleCodeInput(this.checked);
        });

        toggleCodeInput(generateCodeCheckboxSelector[0].checked);
    });
</script>
@endsection
