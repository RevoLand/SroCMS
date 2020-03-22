@extends('layout')

@section('pagetitle', 'Create E-Pin')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Create E-Pin</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.epins.index') }}" class="kt-subheader__breadcrumbs-link">E-Pin System</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.epins.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create</a>
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
                        Create E-Pin
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.epins.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List E-Pins
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.epins.store'], 'class' => 'kt-form', 'method' => 'post']) }}
                    <div class="form-group">
                        <label>Code</label>
                        {{ Form::text('code', old('code'), ['class' => 'form-control code-input']) }}
                        <br />
                        <label class="kt-checkbox">
                            {!! Form::checkbox('generate-code', 1, true) !!} Auto Generate Code
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Reward Type</label>
                        <select class="form-control select2" id="type" name="type" required>
                            <option></option>
                            <option value="1" @if(old('type') == 1) selected @endif>Balance</option>
                            <option value="2" @if(old('type') == 2) selected @endif>Balance (Point)</option>
                            <option value="3" @if(old('type') == 3) selected @endif>Silk</option>
                            <option value="4" @if(old('type') == 4) selected @endif>Silk (Gift)</option>
                            <option value="5" @if(old('type') == 5) selected @endif>Silk (Point)</option>
                            <option value="6" @if(old('type') == 6) selected @endif>Item</option>
                        </select>
                    </div>
                    <div class="form-group balance-selector">
                        <label>Balance / Amount</label>
                        {{ Form::text('balance', old('balance'), ['class' => 'form-control']) }}
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 1, old('enabled', true)) !!} Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                {!! Form::radio('enabled', 0, !old('enabled', true)) !!} Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
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

    toggleFields('{{ old('type') }}');

    var generateCodeCheckboxSelector = $( "input[name='generate-code']");

    generateCodeCheckboxSelector.click(function() {
        toggleCodeInput(this.checked);
    });

    toggleCodeInput(generateCodeCheckboxSelector[0].checked);

});
</script>
@endsection
