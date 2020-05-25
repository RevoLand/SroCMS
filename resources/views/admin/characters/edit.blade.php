@extends('layout')

@section('pagetitle', 'Edit Character')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Character</h5>
        <div>
            <a class="btn btn-falcon-info " href="{{ route('admin.characters.index') }}">Character List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                @if($character !== '')
                    <div class="media align-items-center">
                        <img class="d-flex align-self-center mr-2" src="{{ asset('vendor/img/silkroad/characters/' . $character->RefObjID . '.gif') }}" alt="{{ $character->CharName16 }}">
                        <div class="media-body">
                            <h5 class="mb-0"><a href="{{ route('admin.characters.show', $character) }}">{{ $character->CharName16 }}</a></h5>
                            <h6 class="mb-0">Account: <a href="{{ route('admin.users.show', $character->user->account->JID) }}">{{ $character->user->account->StrUserID }}</a></h6>
                        </div>
                    </div>
                @else
                <div class="form-group">
                    <label>Character</label>
                    <select class="select2 character_select2" v-model="character.CharID" required><option value="" selected></option></select>
                </div>
                @endif
                <hr class="my-3" />
                <div class="fancy-tab" v-show="character != ''">
                    <div class="nav-bar">
                        <div class="nav-bar-item px-3 px-sm-4 active">Basic Information</div>
                    </div>
                    <div class="tab-contents" v-if="character != ''">
                        <div class="tab-content active">
                            <div class="form-group">
                                <label for="CharName16">Character Name <small class="text-muted" v-if="character.CharName16_original && character.CharName16 != character.CharName16_original">(Original Name: @{{ character.CharName16_original }})</small></label>
                                <input type="text" id="CharName16" class="form-control" v-model.trim="character.CharName16" :disabled="character.force_name_change == 1" />
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="auto_generate_password" type="checkbox" :disabled="HasPendingNameChange && character.force_name_change != 1" v-model="character.force_name_change" true-value="1" false-value="0" />
                                        <label class="custom-control-label" for="auto_generate_password">Force Name Change</label>
                                        <small class="text-muted">Forces user to change name at next login.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="NickName16">Job Name</label>
                                <input type="text" id="NickName16" class="form-control" v-model.trim="character.NickName16" />
                            </div>
                            <button type="button" class="btn btn-falcon-primary" @click="UpdateCharacterName">Save</button>
                        </div>
                    </div>
                </div>
                {{-- tabs ends here --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            character: @json($character ?? '')
        },
        created() {
            if (this.character == '') {
                this.character = [];
            }
        },
        computed: {
            HasPendingNameChange: function() {
                if (is.startWith(this.character.CharName16, '@')) {
                    return true;
                }

                return false;
            }
        },
        watch: {
            'character.CharID': function(newValue, oldValue) {
                if (is.empty(newValue) || newValue == oldValue) {
                    return;
                }

                $(".content").block();
                axios.get(route('admin.ajax.characters.get_info', newValue).url())
                .then(response => {
                    if (is.existy(response.data.character)) {
                        this.character = response.data.character;
                    }
                })
                .finally(() => {
                    $(".content").unblock();
                });
            },
            'character.CharName16': function(newValue, oldValue) {
                if (is.empty(oldValue) || is.existy(this.character.CharName16_original)) {
                    return;
                }

                this.character.CharName16_original = oldValue;
            },
            'character.force_name_change': function(newValue, oldValue) {
                if (newValue == 1 && this.HasPendingNameChange) {
                    return;
                }

                if (newValue == 1) {
                    this.character.CharName16 = `@${this.character.CharName16}`;
                } else {
                    if (is.startWith(this.character.CharName16, '@')) {
                        this.character.CharName16 = this.character.CharName16_original || _.replace(this.character.CharName16, '@', '');
                    }
                }
            }
        },
        methods: {
            UpdateCharacterName: function() {
                let nameChangeForm = new Form({
                    CharName16: this.character.CharName16,
                    NickName16: this.character.NickName16,
                    force_name_change: this.character.force_name_change
                });

                nameChangeForm.patch(route('admin.characters.update_character_name', this.character.CharID).url());
            }
        }
    });

@empty($character)
    $(document).ready(function() {
        $('.character_select2').select2({
            placeholder: 'Search for Character',
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
    });
@endif
</script>
@endsection
