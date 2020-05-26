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
                        <img class="d-flex align-self-center mr-2" :src="character_image" alt="{{ $character->CharName16 }}">
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
                        <div class="nav-bar-item px-3 px-sm-4">Basic Information</div>
                        <div class="nav-bar-item px-3 px-sm-4">Name / Job Name</div>
                        <div class="nav-bar-item px-3 px-sm-4 active" v-if="character.guildmember">Guild</div>
                    </div>
                    <div class="tab-contents" v-if="character != ''">
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="level">Level</label>
                                        <input id="level" class="form-control" type="number" step="1" min="1" max="140" v-model="character.CurLevel" />
                                    </div>
                                    <div class="form-group">
                                        <label for="strength">Strength</label>
                                        <input id="strength" class="form-control" type="number" step="1" min="1" max="30000" v-model="character.Strength" />
                                    </div>
                                    <div class="form-group">
                                        <label for="intellect">Intellect</label>
                                        <input id="intellect" class="form-control" type="number" step="1" min="1" max="30000" v-model="character.Intellect" />
                                    </div>
                                    <div class="form-group">
                                        <label for="refobjid">Model (RefObjID)</label>
                                        <select id="refobjid" class="custom-select" v-model="character.RefObjID">
                                            <option v-for="characters in available_characters[character_race]" :value="characters" v-text="characters"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gold">Gold</label>
                                        <input id="gold" class="form-control" type="number" step="1" min="0" max="9000000000000000000" v-model="character.RemainGold">
                                    </div>
                                    <div class="form-group">
                                        <label for="skillpoint">Skill Points</label>
                                        <input id="skillpoint" class="form-control" type="number" step="1" min="0" max="2000000000" v-model="character.RemainSkillPoint">
                                    </div>
                                    <div class="form-group">
                                        <label for="statpoint">Stat Points</label>
                                        <input id="statpoint" class="form-control" type="number" step="1" min="0" max="32000" v-model="character.RemainStatPoint">
                                    </div>
                                    <div class="form-group">
                                        <label for="inventorysize">Inventory Size</label>
                                        <input id="inventorysize" class="form-control" type="number" step="1" min="45" max="109" v-model="character.InventorySize">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-falcon-primary" @click="UpdateBasicInformation">Save</button>
                        </div>
                        <div class="tab-content">
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
                        <div class="tab-content active" v-if="character.guildmember">
                            <div class="form-group">
                                <label for="guildmember_nickname">Nickname</label>
                                <input id="guildmember_nickname" type="text" class="form-control" v-model.trim="character.guildmember.Nickname" maxlength="64">
                            </div>
                            <div class="form-group">
                                <label>Permissions</label>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="permission_join" type="checkbox" v-model="guild_permission_join" :disabled="character.guildmember.MemberClass == 0">
                                    <label class="custom-control-label" for="permission_join">Join</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="permission_withdraw" type="checkbox" v-model="guild_permission_withdraw" :disabled="character.guildmember.MemberClass == 0">
                                    <label class="custom-control-label" for="permission_withdraw">Withdraw (Kick)</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="permission_union" type="checkbox" v-model="guild_permission_union" :disabled="character.guildmember.MemberClass == 0">
                                    <label class="custom-control-label" for="permission_union">Union Chat</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="permission_storage" type="checkbox" v-model="guild_permission_storage" :disabled="character.guildmember.MemberClass == 0">
                                    <label class="custom-control-label" for="permission_storage">Guild Storage</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="permission_notice" type="checkbox" v-model="guild_permission_notice" :disabled="character.guildmember.MemberClass == 0">
                                    <label class="custom-control-label" for="permission_notice">Notice</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Siege Authority</label>
                                <h6 v-text="available_siege_perms[character.guildmember.SiegeAuthority]"></h6>
                            </div>
                            <button type="button" class="btn btn-falcon-primary" @click="UpdateGuildmemberInformation">Save</button>
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
            assets_base_url: @json(asset('vendor/img/silkroad/characters/')),
            character: @json($character ?? ''),
            available_characters: {
                1: _.range(1907, 1933, 1),
                2: _.range(14875, 14901, 1)
            },
            available_siege_perms: @json(config('constants.guild.siege'))
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
            },
            character_image: function() {
                if (is.empty(this.character.RefObjID)) {
                    return '';
                }

                return `${this.assets_base_url}/${this.character.RefObjID}.gif`;
            },
            character_race: function() {
                if (this.character.RefObjID <= 1932) {
                    return 1;
                }

                return 2;
            },
            guild_permission_join: {
                get: function() {
                    return this.character.guildmember.Permission & 1;
                },
                set: function(newValue) {
                    if (newValue) {
                        this.character.guildmember.Permission = this.character.guildmember.Permission | 1;
                    } else {
                        this.character.guildmember.Permission = this.character.guildmember.Permission ^ 1;
                    }
                }
            },
            guild_permission_withdraw: {
                get: function() {
                    return this.character.guildmember.Permission & 2;
                },
                set: function(newValue) {
                    if (newValue) {
                        this.character.guildmember.Permission = this.character.guildmember.Permission | 2;
                    } else {
                        this.character.guildmember.Permission = this.character.guildmember.Permission ^ 2;
                    }
                }
            },
            guild_permission_union: {
                get: function() {
                    return this.character.guildmember.Permission & 4;
                },
                set: function(newValue) {
                    if (newValue) {
                        this.character.guildmember.Permission = this.character.guildmember.Permission | 4;
                    } else {
                        this.character.guildmember.Permission = this.character.guildmember.Permission ^ 4;
                    }
                }
            },
            guild_permission_storage: {
                get: function() {
                    return this.character.guildmember.Permission & 8;
                },
                set: function(newValue) {
                    if (newValue) {
                        this.character.guildmember.Permission = this.character.guildmember.Permission | 8;
                    } else {
                        this.character.guildmember.Permission = this.character.guildmember.Permission ^ 8;
                    }
                }
            },
            guild_permission_notice: {
                get: function() {
                    return this.character.guildmember.Permission & 16;
                },
                set: function(newValue) {
                    if (newValue) {
                        this.character.guildmember.Permission = this.character.guildmember.Permission | 16;
                    } else {
                        this.character.guildmember.Permission = this.character.guildmember.Permission ^ 16;
                    }
                }
            },
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
            UpdateBasicInformation: function() {
                let basicInfoForm = new Form({
                    level: this.character.CurLevel,
                    strength: this.character.Strength,
                    intellect: this.character.Intellect,
                    refobjid: this.character.RefObjID,

                    gold: this.character.RemainGold,
                    skillpoint: this.character.RemainSkillPoint,
                    statpoint: this.character.RemainStatPoint,
                    inventorysize: this.character.InventorySize
                });

                basicInfoForm.patch(route('admin.characters.update_basic_information', this.character.CharID).url());
            },
            UpdateCharacterName: function() {
                let nameChangeForm = new Form({
                    CharName16: this.character.CharName16,
                    NickName16: this.character.NickName16,
                    force_name_change: this.character.force_name_change
                });

                nameChangeForm.patch(route('admin.characters.update_character_name', this.character.CharID).url());
            },
            UpdateGuildmemberInformation: function() {
                let guildMemberInfoForm = new Form({
                    nickname: this.character.guildmember.Nickname,
                    permission: this.character.guildmember.Permission
                });

                guildMemberInfoForm.patch(route('admin.characters.update_guild_information', this.character.CharID).url());
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
