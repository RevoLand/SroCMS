@extends('layout')

@section('pagetitle', 'Edit User')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit User</h5>
        <div>
            <a class="btn btn-falcon-info " href="{{ route('admin.users.index') }}">User List</a>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12">
                @if($user !== '')
                    <div class="media align-items-center">
                        @isset($user->gravatar)
                        <img class="d-flex align-self-center mr-2" src="{{ $user->gravatar }}" alt="{{ $user->StrUserID }}" width="30">
                        @endisset
                        <div class="media-body">
                            <h6 class="mb-0"><a href="{{ route('admin.users.show', $user) }}">{{ $user->StrUserID }}</a></h6>
                            @isset($user->Name) <small class="text-muted font-italic">{{ $user->Name }}</small> @endisset
                        </div>
                    </div>
                    @isset($user->regtime) <small>User since: {{ $user->regtime }}</small> @endisset
                @else
                <div class="form-group">
                    <label>User</label>
                    <select class="select2 user_select2" v-model="user.JID" required><option value="" selected></option></select>
                </div>
                @endif
                <hr class="my-3" />
                <div class="fancy-tab" v-show="user != ''">
                    <div class="nav-bar">
                        <div class="nav-bar-item px-3 px-sm-4 active">Basic Information</div>
                        <div class="nav-bar-item px-3 px-sm-4">Change Password</div>
                        <div class="nav-bar-item px-3 px-sm-4">Change E-mail</div>
                        <div class="nav-bar-item px-3 px-sm-4">Balance Management</div>
                        <div class="nav-bar-item px-3 px-sm-4">Silk Management</div>
                    </div>
                    <div class="tab-contents" v-if="user != ''">
                        <div class="tab-content active">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" class="form-control" v-model="user.Name" />
                            </div>
                            <div class="form-group">
                                <label for="regdate">Registration Date</label>
                                <input id="regdate" type="datetime" class="form-control flatpickr" v-model="user.regtime" />
                            </div>
                            <div class="form-group">
                              <label for="reg_ip">Registration IP</label>
                              <input type="text" id="reg_ip" class="form-control" v-model="user.reg_ip">
                            </div>
                            <button type="button" class="btn btn-falcon-primary" @click="updateUserInformation">Save</button>
                        </div>
                        {{-- password-change-tab --}}
                        <div class="tab-content form-validation">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="auto_generate_password" type="checkbox" v-model="password_change_form.auto_generate" true-value="1" false-value="0" />
                                    <label class="custom-control-label" for="auto_generate_password">Auto-Generate Password</label>
                                </div>
                            </div>
                            <template v-if="password_change_form.auto_generate != '1'">
                                <div class="form-group">
                                    <label for="new_password">New Password:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-falcon-info" v-text="password_change_form.show_new_password ? 'Hide' : 'Show'" @click="password_change_form.show_new_password = !password_change_form.show_new_password"></button>
                                        </div>
                                        <input id="new_password" :type="password_change_form.show_new_password ? 'text' : 'password'" class="form-control" v-model="password_change_form.new_password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="new_password_confirmation">Confirm New Password:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-sm btn-falcon-info" v-text="password_change_form.show_new_password_confirmation ? 'Hide' : 'Show'" @click="password_change_form.show_new_password_confirmation = !password_change_form.show_new_password_confirmation"></button>
                                        </div>
                                        <input id="new_password_confirmation" :type="password_change_form.show_new_password_confirmation ? 'text' : 'password'" :class="{ 'error': password_change_form.new_password_confirmation.length > 0 && password_change_form.new_password != password_change_form.new_password_confirmation }" class="form-control" v-model="password_change_form.new_password_confirmation" />
                                    </div>
                                    <label class="error" for="new_password_confirmation" v-if="password_change_form.new_password_confirmation.length > 0 && password_change_form.new_password != password_change_form.new_password_confirmation">
                                        Given passwords doesn't matches!
                                    </label>
                                </div>
                            </template>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="inform_mail_user_for_password_change" type="checkbox" v-model="password_change_form.inform_mail_user" true-value="1" false-value="0" />
                                    <label class="custom-control-label" for="inform_mail_user_for_password_change">Send new password to User's Registered Mail <template v-if="user.Email"><small class="text-muted">( <span v-text="user.Email"></span> )</small></template></label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-falcon-primary" :disabled="CanSendChangePasswordForm" @click="changePassword">Change Password</button>
                        </div>
                        {{-- /password-change-tab --}}
                        {{-- email-change-tab --}}
                        <div class="tab-content form-validation">
                            <div class="form-group">
                                <label for="current_email">Current E-mail</label>
                                <input id="current_email" class="form-control" type="email" v-model="user.Email" readonly />
                            </div>
                            <div class="form-group">
                                <label for="new_email">New E-mail</label>
                                <input id="new_email" class="form-control" type="email" :class="{ 'error': user.Email == email_change_form.new_email }" v-model="email_change_form.new_email" />
                                <label class="error" for="new_email" v-if="user.Email == email_change_form.new_email">
                                    New E-mail can not be same with user's current E-mail!
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="new_email_confirmation">Confirm New E-mail</label>
                                <input id="new_email_confirmation" class="form-control" type="email" :class="{ 'error': email_change_form.new_email_confirmation.length > 0 &&  email_change_form.new_email != email_change_form.new_email_confirmation }" v-model="email_change_form.new_email_confirmation" />
                                <label class="error" for="new_email_confirmation" v-if="email_change_form.new_email_confirmation.length > 0 && email_change_form.new_email != email_change_form.new_email_confirmation">
                                    E-mail address confirmation doesn't match!
                                </label>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input" id="inform_old_email" type="checkbox" v-model="email_change_form.inform_old_email" true-value="1" false-value="0" />
                                    <label class="custom-control-label" for="inform_old_email">Notify old E-mail</label>
                                    <small class="text-muted" v-if="user.Email" v-text="user.Email"></small>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input class="custom-control-input" id="inform_new_email" type="checkbox" v-model="email_change_form.inform_new_email" true-value="1" false-value="0" />
                                    <label class="custom-control-label" for="inform_new_email">Notify new E-mail</label>
                                    <small class="text-muted" v-if="email_change_form.new_email" v-text="email_change_form.new_email"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" id="reset_email_confirmation_state" type="checkbox" v-model="email_change_form.reset_email_verification_state" true-value="1" false-value="0" />
                                    <label class="custom-control-label" for="reset_email_confirmation_state">Reset E-mail Confirmation State</label>
                                    <small class="text-muted">If enabled, user will have to verify his/her e-mail again.</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-falcon-primary" @click="changeEmail" :disabled="CanSendChangeEmailForm">Change E-mail</button>
                        </div>
                        {{-- /email-change-tab --}}
                        {{-- balance-management-tab --}}
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="balance">Balance</label>
                                        <input id="balance" type="number" class="form-control" min="0" step="any" v-model.number="user.balance.balance" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <label>Increase Balance</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="increaseBalance(5, 'balance')" class="btn btn-sm btn-falcon-success">+5</button>
                                                <button type="button" @click="increaseBalance(10, 'balance')" class="btn btn-sm btn-falcon-success">+10</button>
                                                <button type="button" @click="increaseBalance(20, 'balance')" class="btn btn-sm btn-falcon-success">+20</button>
                                                <button type="button" @click="increaseBalance(50, 'balance')" class="btn btn-sm btn-falcon-success">+50</button>
                                                <button type="button" @click="increaseBalance(100, 'balance')" class="btn btn-sm btn-falcon-success">+100</button>
                                                <button type="button" @click="increaseBalance(200, 'balance')" class="btn btn-sm btn-falcon-success">+200</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <label>Decrease Balance</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="decreaseBalance(5, 'balance')" class="btn btn-sm btn-falcon-danger">-5</button>
                                                <button type="button" @click="decreaseBalance(10, 'balance')" class="btn btn-sm btn-falcon-danger">-10</button>
                                                <button type="button" @click="decreaseBalance(20, 'balance')" class="btn btn-sm btn-falcon-danger">-20</button>
                                                <button type="button" @click="decreaseBalance(50, 'balance')" class="btn btn-sm btn-falcon-danger">-50</button>
                                                <button type="button" @click="decreaseBalance(100, 'balance')" class="btn btn-sm btn-falcon-danger">-100</button>
                                                <button type="button" @click="decreaseBalance(200, 'balance')" class="btn btn-sm btn-falcon-danger">-200</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="balance_point">Balance (Point)</label>
                                        <input id="balance_point" type="number" class="form-control" min="0" step="any" v-model.number="user.balance.balance_point" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <label>Increase Balance (Point)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="increaseBalance(5, 'balance_point')" class="btn btn-sm btn-falcon-success">+5</button>
                                                <button type="button" @click="increaseBalance(10, 'balance_point')" class="btn btn-sm btn-falcon-success">+10</button>
                                                <button type="button" @click="increaseBalance(20, 'balance_point')" class="btn btn-sm btn-falcon-success">+20</button>
                                                <button type="button" @click="increaseBalance(50, 'balance_point')" class="btn btn-sm btn-falcon-success">+50</button>
                                                <button type="button" @click="increaseBalance(100, 'balance_point')" class="btn btn-sm btn-falcon-success">+100</button>
                                                <button type="button" @click="increaseBalance(200, 'balance_point')" class="btn btn-sm btn-falcon-success">+200</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <label>Decrease Balance (Point)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="decreaseBalance(5, 'balance_point')" class="btn btn-sm btn-falcon-danger">-5</button>
                                                <button type="button" @click="decreaseBalance(10, 'balance_point')" class="btn btn-sm btn-falcon-danger">-10</button>
                                                <button type="button" @click="decreaseBalance(20, 'balance_point')" class="btn btn-sm btn-falcon-danger">-20</button>
                                                <button type="button" @click="decreaseBalance(50, 'balance_point')" class="btn btn-sm btn-falcon-danger">-50</button>
                                                <button type="button" @click="decreaseBalance(100, 'balance_point')" class="btn btn-sm btn-falcon-danger">-100</button>
                                                <button type="button" @click="decreaseBalance(200, 'balance_point')" class="btn btn-sm btn-falcon-danger">-200</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="balance_change_reason">Change Reason <small class="text-muted">Optional</small></label>
                                <input id="balance_change_reason" type="text" maxlength="255" class="form-control" v-model="user.balance.change_reason" />
                            </div>
                            <button type="button" class="btn btn-falcon-primary" :disabled="CanSendUpdateBalanceForm" @click="updateBalance">Save</button>
                        </div>
                        {{-- /balance-management-tab --}}
                        {{-- silk management tab --}}
                        <div class="tab-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="silk_own">Silk</label>
                                        <input id="silk_own" type="number" class="form-control" min="0" step="1" v-model.number="user.silk.silk_own" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <label>Increase Silk</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="increaseSilk(5, 'silk_own')" class="btn btn-sm btn-falcon-success">+5</button>
                                                <button type="button" @click="increaseSilk(10, 'silk_own')" class="btn btn-sm btn-falcon-success">+10</button>
                                                <button type="button" @click="increaseSilk(20, 'silk_own')" class="btn btn-sm btn-falcon-success">+20</button>
                                                <button type="button" @click="increaseSilk(50, 'silk_own')" class="btn btn-sm btn-falcon-success">+50</button>
                                                <button type="button" @click="increaseSilk(100, 'silk_own')" class="btn btn-sm btn-falcon-success">+100</button>
                                                <button type="button" @click="increaseSilk(200, 'silk_own')" class="btn btn-sm btn-falcon-success">+200</button>
                                                <button type="button" @click="increaseSilk(500, 'silk_own')" class="btn btn-sm btn-falcon-success">+500</button>
                                                <button type="button" @click="increaseSilk(1000, 'silk_own')" class="btn btn-sm btn-falcon-success">+1000</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <label>Decrease Silk</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="decreaseSilk(5, 'silk_own')" class="btn btn-sm btn-falcon-danger">-5</button>
                                                <button type="button" @click="decreaseSilk(10, 'silk_own')" class="btn btn-sm btn-falcon-danger">-10</button>
                                                <button type="button" @click="decreaseSilk(20, 'silk_own')" class="btn btn-sm btn-falcon-danger">-20</button>
                                                <button type="button" @click="decreaseSilk(50, 'silk_own')" class="btn btn-sm btn-falcon-danger">-50</button>
                                                <button type="button" @click="decreaseSilk(100, 'silk_own')" class="btn btn-sm btn-falcon-danger">-100</button>
                                                <button type="button" @click="decreaseSilk(200, 'silk_own')" class="btn btn-sm btn-falcon-danger">-200</button>
                                                <button type="button" @click="decreaseSilk(500, 'silk_own')" class="btn btn-sm btn-falcon-danger">-500</button>
                                                <button type="button" @click="decreaseSilk(1000, 'silk_own')" class="btn btn-sm btn-falcon-danger">-1000</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="silk_gift">Silk (Gift)</label>
                                        <input id="silk_gift" type="number" class="form-control" min="0" step="1" v-model.number="user.silk.silk_gift" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <label>Increase Silk (Gift)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="increaseSilk(5, 'silk_gift')" class="btn btn-sm btn-falcon-success">+5</button>
                                                <button type="button" @click="increaseSilk(10, 'silk_gift')" class="btn btn-sm btn-falcon-success">+10</button>
                                                <button type="button" @click="increaseSilk(20, 'silk_gift')" class="btn btn-sm btn-falcon-success">+20</button>
                                                <button type="button" @click="increaseSilk(50, 'silk_gift')" class="btn btn-sm btn-falcon-success">+50</button>
                                                <button type="button" @click="increaseSilk(100, 'silk_gift')" class="btn btn-sm btn-falcon-success">+100</button>
                                                <button type="button" @click="increaseSilk(200, 'silk_gift')" class="btn btn-sm btn-falcon-success">+200</button>
                                                <button type="button" @click="increaseSilk(500, 'silk_gift')" class="btn btn-sm btn-falcon-success">+500</button>
                                                <button type="button" @click="increaseSilk(1000, 'silk_gift')" class="btn btn-sm btn-falcon-success">+1000</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <label>Decrease Silk (Gift)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="decreaseSilk(5, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-5</button>
                                                <button type="button" @click="decreaseSilk(10, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-10</button>
                                                <button type="button" @click="decreaseSilk(20, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-20</button>
                                                <button type="button" @click="decreaseSilk(50, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-50</button>
                                                <button type="button" @click="decreaseSilk(100, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-100</button>
                                                <button type="button" @click="decreaseSilk(200, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-200</button>
                                                <button type="button" @click="decreaseSilk(500, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-500</button>
                                                <button type="button" @click="decreaseSilk(1000, 'silk_gift')" class="btn btn-sm btn-falcon-danger">-1000</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="silk_point">Silk (Point)</label>
                                        <input id="silk_point" type="number" class="form-control" min="0" step="1" v-model.number="user.silk.silk_point" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md">
                                            <label>Increase Silk (Point)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="increaseSilk(5, 'silk_point')" class="btn btn-sm btn-falcon-success">+5</button>
                                                <button type="button" @click="increaseSilk(10, 'silk_point')" class="btn btn-sm btn-falcon-success">+10</button>
                                                <button type="button" @click="increaseSilk(20, 'silk_point')" class="btn btn-sm btn-falcon-success">+20</button>
                                                <button type="button" @click="increaseSilk(50, 'silk_point')" class="btn btn-sm btn-falcon-success">+50</button>
                                                <button type="button" @click="increaseSilk(100, 'silk_point')" class="btn btn-sm btn-falcon-success">+100</button>
                                                <button type="button" @click="increaseSilk(200, 'silk_point')" class="btn btn-sm btn-falcon-success">+200</button>
                                                <button type="button" @click="increaseSilk(500, 'silk_point')" class="btn btn-sm btn-falcon-success">+500</button>
                                                <button type="button" @click="increaseSilk(1000, 'silk_point')" class="btn btn-sm btn-falcon-success">+1000</button>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <label>Decrease Silk (Point)</label>
                                            <div class="btn-group d-flex flex-wrap">
                                                <button type="button" @click="decreaseSilk(5, 'silk_point')" class="btn btn-sm btn-falcon-danger">-5</button>
                                                <button type="button" @click="decreaseSilk(10, 'silk_point')" class="btn btn-sm btn-falcon-danger">-10</button>
                                                <button type="button" @click="decreaseSilk(20, 'silk_point')" class="btn btn-sm btn-falcon-danger">-20</button>
                                                <button type="button" @click="decreaseSilk(50, 'silk_point')" class="btn btn-sm btn-falcon-danger">-50</button>
                                                <button type="button" @click="decreaseSilk(100, 'silk_point')" class="btn btn-sm btn-falcon-danger">-100</button>
                                                <button type="button" @click="decreaseSilk(200, 'silk_point')" class="btn btn-sm btn-falcon-danger">-200</button>
                                                <button type="button" @click="decreaseSilk(500, 'silk_point')" class="btn btn-sm btn-falcon-danger">-500</button>
                                                <button type="button" @click="decreaseSilk(1000, 'silk_point')" class="btn btn-sm btn-falcon-danger">-1000</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="silk_change_reason">Change Reason <small class="text-muted">Optional</small></label>
                                <input id="silk_change_reason" type="text" maxlength="255" class="form-control" v-model="user.silk.change_reason" />
                            </div>
                            <button type="button" class="btn btn-falcon-primary" :disabled="CanSendUpdateSilkForm" @click="updateSilk">Save</button>
                        </div>
                        {{-- /silk management tab --}}
                    </div>
                </div>
                {{-- tabs ends here --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
{!! Theme::js('lib/decimal/decimal.min.js') !!}
{!! Theme::js('lib/flatpickr/flatpickr.min.js') !!}
<script src="{{ asset('vendor/vue/ext/flatpickr.js') }}"></script>
{!! Theme::js('lib/select2/select2.min.js') !!}
<script src="{{ asset('vendor/vue/ext/select2.js') }}"></script>
<script>
    new Vue({
        el: '.content',
        data: {
            user: @json($user ?? ''),
            password_change_form: new Form({
                auto_generate: '1',
                new_password: '',
                new_password_confirmation: '',
                show_new_password: false,
                show_new_password_confirmation: false,
                inform_mail_user: '1'
            }),
            email_change_form: new Form({
                new_email: '',
                new_email_confirmation: '',
                inform_old_email: '0',
                inform_new_email: '1',
                reset_email_verification_state: '1'
            })
        },
        created() {
            if (this.user == '') {
                this.user = [];
            }
        },
        computed: {
            CanSendChangePasswordForm: function() {
                if (is.equal(this.password_change_form.auto_generate, '0')) {
                    if (this.password_change_form.new_password.length == 0) {
                        return true;
                    }

                    if (this.password_change_form.new_password != this.password_change_form.new_password_confirmation) {
                        return true;
                    }
                }

                return false;
            },
            CanSendChangeEmailForm: function() {
                if (this.email_change_form.new_email_confirmation.length == 0
                ||  this.email_change_form.new_email != this.email_change_form.new_email_confirmation
                ||  this.user.Email == this.email_change_form.new_email) {
                    return true;
                }

                return false;
            },
            CanSendUpdateBalanceForm: function() {
                if (is.negative(this.user.balance.balance) || is.negative(this.user.balance.balance_point)) {
                    return true;
                }

                return false;
            },
            CanSendUpdateSilkForm: function() {
                if (is.negative(this.user.silk.silk_own) || is.negative(this.user.silk.silk_gift) || is.negative(this.user.silk.silk_point)) {
                    return true;
                }

                return false;
            }
        },
        watch: {
            'user.JID': function(newValue, oldValue) {
                if (is.empty(newValue) || newValue == oldValue) {
                    return;
                }

                $(".content").block();
                axios.get(route('admin.ajax.users.get_userinfo', newValue).url())
                .then(response => {
                    if (is.existy(response.data.user)) {
                        this.user = response.data.user;
                    }
                })
                .finally(() => {
                    $(".content").unblock();
                });
            },
            'user.balance.balance': function(newValue, oldValue) {
                if (is.negative(newValue)) {
                    this.user.balance.balance = 0;
                }
            },
            'user.balance.balance_point': function(newValue, oldValue) {
                if (is.negative(newValue)) {
                    this.user.balance.balance_point = 0;
                }
            }
        },
        methods: {
            updateUserInformation() {
                let userInfoForm = new Form({
                    name: this.user.Name,
                    regtime: this.user.regtime,
                    reg_ip: this.user.reg_ip
                });

                userInfoForm.patch(route('admin.users.update_information', this.user.JID).url());
            },
            changePassword() {
                this.password_change_form.patch(route('admin.users.update_password', this.user.JID).url())
                .then(response => {
                    this.password_change_form.reset();
                });
            },
            changeEmail() {
                this.email_change_form.patch(route('admin.users.update_email', this.user.JID).url())
                .then(response => {
                    this.user.Email = this.email_change_form.new_email;
                    this.email_change_form.reset();
                });
            },
            updateBalance() {
                let balanceForm = new Form({
                    balance: this.user.balance.balance,
                    balance_point: this.user.balance.balance_point,
                    reason: this.user.balance.change_reason
                });

                balanceForm.patch(route('admin.users.update_balance', this.user.JID).url());
            },
            updateSilk() {
                let silkForm = new Form({
                    silk_own: this.user.silk.silk_own,
                    silk_gift: this.user.silk.silk_gift,
                    silk_point: this.user.silk.silk_point,
                    reason: this.user.silk.change_reason
                });

                silkForm.patch(route('admin.users.update_silk', this.user.JID).url());
            },
            increaseBalance(balance, balanceType) {
                this.user.balance[balanceType] = new Decimal(this.user.balance[balanceType]).plus(new Decimal(balance));
            },
            decreaseBalance(balance, balanceType) {
                let newBalance = new Decimal(this.user.balance[balanceType]).minus(new Decimal(balance));

                if (newBalance.isNegative()) {
                    console.log('negative');
                    newBalance = 0;
                }

                this.user.balance[balanceType] = newBalance;
            },
            increaseSilk(silk, silkType) {
                let newSilk = Number(this.user.silk[silkType]) + Number(silk);
                this.user.silk[silkType] = newSilk;
            },
            decreaseSilk(silk, silkType) {
                let newSilk = Number(this.user.silk[silkType]) - Number(silk);

                if (newSilk < 0) {
                    newSilk = 0;
                }

                this.user.silk[silkType] = newSilk;
            }
        }
    });

@empty($user)
    $(document).ready(function() {
        $('.user_select2').select2({
            placeholder: 'Search for Character/User',
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
    });
@endif
</script>
@endsection
