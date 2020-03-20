@extends('layout')

@section('pagetitle', 'Edit Vote Reward')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Vote Reward</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.index') }}" class="kt-subheader__breadcrumbs-link">Vote System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.providers.index') }}" class="kt-subheader__breadcrumbs-link">Vote Providers</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.rewards.index', $reward->vote_provider_reward_group_id) }}" class="kt-subheader__breadcrumbs-link">Rewards</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.votes.rewards.edit', $reward) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
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
                        Edit Vote Reward
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.votes.rewards.create', $reward->vote_provider_reward_group_id) }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> Create Reward
                        </a>
                        <a href="{{ route('admin.votes.rewards.index', $reward->vote_provider_reward_group_id) }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Rewards
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.votes.rewards.update', $reward], 'class' => 'kt-form', 'method' => 'patch']) }}
                    <div class="form-group">
                        <label>Reward Group</label>
                        <select class="form-control select2" name="reward_group_id" required>
                            <option></option>
                            @foreach($rewardgroups->sortByDesc('enabled') as $reward_group)
                                <option value="{{ $reward_group->id }}" @if($reward_group->id == $reward->vote_provider_reward_group_id) selected @endif>
                                    [{{ $reward_group->id }}] {{ $reward_group->name }} (@if($reward_group->enabled) Enabled @else Disabled @endif)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Reward Type</label>
                        <select class="form-control select2" id="type" name="type" required>
                            <option></option>
                            <option value="1" @if($reward->type == 1) selected @endif>Balance</option>
                            <option value="2" @if($reward->type == 2) selected @endif>Balance (Point)</option>
                            <option value="3" @if($reward->type == 3) selected @endif>Silk</option>
                            <option value="4" @if($reward->type == 4) selected @endif>Silk (Gift)</option>
                            <option value="5" @if($reward->type == 5) selected @endif>Silk (Point)</option>
                            <option value="6" @if($reward->type == 6) selected @endif>Item</option>
                        </select>
                    </div>
                    <div class="form-group codename-selector">
                        <label>CodeName</label>
                        {{ Form::text('codename', $reward->codename, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group amount-selector">
                        <label>Amount</label>
                        {{ Form::text('amount', $reward->amount ?? 1, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group balance-selector">
                        <label>Balance</label>
                        {{ Form::text('balance', $reward->balance, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group plus-selector">
                        <label>Plus</label>
                        {{ Form::text('plus', $reward->plus, ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, $reward->enabled) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !$reward->enabled) !!} Disabled
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
                                    {!! Form::open([ 'route' => ['admin.votes.rewards.destroy', $reward], 'method' => 'delete']) !!}
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- end:: Content -->
</div>
@endsection


@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $( ".select2" ).select2({
        placeholder: "Please make a selection..."
    });

    function toggleFields(typeId) {
        switch(typeId) {
            default:
            case '1':
            case '2':
                $( ".codename-selector" ).hide({});
                $( ".amount-selector" ).hide({});
                $( ".plus-selector" ).hide({});
                $( ".balance-selector" ).show({});
            break;
            case '3':
            case '4':
            case '5':
                $( ".codename-selector" ).hide({});
                $( ".plus-selector" ).hide({});
                $( ".balance-selector" ).hide({});
                $( ".amount-selector" ).show({});
            break;
            case '6':
                $( ".balance-selector" ).hide({});
                $( ".codename-selector" ).show({});
                $( ".plus-selector" ).show({});
                $( ".amount-selector" ).show({});
            break;
        };
    };

    $( "#type" ).change(function() {
        toggleFields(this.value);
    });

    toggleFields('{{ $reward->type }}');
});
</script>
@endsection
