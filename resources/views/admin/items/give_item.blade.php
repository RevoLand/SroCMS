@extends('layout')

@section('pagetitle', 'Give Item')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Give Item to Character / Account</h5>
        <div>
            <a class="btn btn-falcon-info " href="{{ route('admin.characters.index') }}">Character List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Give Item To</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="give_item_character" v-model.number="type" value="1"/>
                            <label for="give_item_character" class="custom-control-label">Character Name</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="give_item_account" v-model.number="type" value="2"/>
                            <label for="give_item_account" class="custom-control-label">Account Name</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" v-show="type == 1">
                    <label for="character">Character</label>
                    <select id="character" class="select2 character_select2" v-model="character"><option value="" selected></option></select>
                </div>
                <div class="form-group" v-show="type == 2">
                    <label for="user">User</label>
                    <select id="user" class="select2 user_select2" v-model="account"><option value="" selected></option></select>
                </div>
                <div class="form-group">
                    <label for="codename">Item (CodeName)</label>
                    <select id="codename" class="select2 item_select2" v-model.trim="codename" required><option value="" selected></option></select>
                </div>
                <div class="form-group">
                    <label for="data">Data (Count)</label>
                    <input id="data" type="text" class="form-control" v-model.trim="quantity" min="1" />
                </div>
                <div class="form-group">
                    <label for="optlevel">Plus (OptLevel)</label>
                    <input id="optlevel" type="number" max="32" class="form-control" min="0" v-model.number.trim="optlevel">
                </div>
                <div class="form-group" v-if="type == 1">
                    <label>Item To</label>
                    <div class="row col-12">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="item_to_inventory" v-model.number="target" value="1"/>
                            <label for="item_to_inventory" class="custom-control-label">Character Inventory</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="item_to_storage" v-model.number="target" value="2"/>
                            <label for="item_to_storage" class="custom-control-label">Account Storage</label>
                        </div>
                    </div>
                </div>
                <button class="btn btn-falcon-primary" type="button" :disabled="codename == '' || plus < 0 || quantity < 0 || (type == 1 && !character) || (type == 2 && !account)" @click="GiveItem">Give Item</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            type: 1, // 1 => character || 2 => account
            target: 1, // 1 => inventory || 2 => account storage
            character: '',
            account: '',
            codename: '',
            quantity: 1,
            optlevel: 0
        },
        methods: {
            GiveItem: function() {
                let itemForm = new Form({
                    type: this.type,
                    target: this.target,
                    character: this.character,
                    account: this.account,
                    codename: this.codename,
                    quantity: this.quantity,
                    optlevel: this.optlevel
                });

                itemForm.post(route('admin.item-manager.give_item').url());
            }
        },

    });

    $(document).ready(function() {
        $('.character_select2').select2({
            placeholder: 'Search for Character (Name or Job Name)',
            minimumInputLength: 2,
            allowClear: false,
            dropdownAutoWidth: true,
            ajax: {
                url: route('admin.ajax.characters.get_names').url(),
                dataType: 'json',
                delay: 300,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (response, params) {
                    return {
                        results: response.data,
                        pagination: {
                            more: ((params.page || 1) < response.last_page)
                        }
                    };
                },
            }
        });

        $('.user_select2').select2({
            placeholder: 'Search for User',
            minimumInputLength: 2,
            allowClear: false,
            dropdownAutoWidth: true,
            ajax: {
                url: route('admin.ajax.users.get_usernames').url(),
                dataType: 'json',
                delay: 300,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (response, params) {
                    return {
                        results: response.data,
                        pagination: {
                            more: ((params.page || 1) < response.last_page)
                        }
                    };
                },
            }
        });

        $('.item_select2').select2({
            placeholder: 'Search for Item (CodeName or Item Name)',
            minimumInputLength: 3,
            allowClear: false,
            dropdownAutoWidth: true,
            tags: true,
            ajax: {
                url: route('admin.ajax.items.get_enabled_items').url(),
                dataType: 'json',
                delay: 300,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (response, params) {
                    return {
                        results: response.data,
                        pagination: {
                            more: ((params.page || 1) < response.last_page)
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
