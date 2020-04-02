@extends('layout')

@section('pagetitle', 'Create Category')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Create Category</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.categories.index') }}" class="kt-subheader__breadcrumbs-link">Categories</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.categories.create') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Create Category</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Subheader -->

    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Create Category
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('admin.articles.categories.index') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Categories
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.articles.categories.store'], 'class' => 'kt-form', 'method' => 'post', '@submit.prevent' => 'submitForm']) }}
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="name" required>
                        <label class="kt-checkbox mt-2">
                            <input type="checkbox" class="form-control" v-model="generate_slug" true-value="1" false-value="0"> Auto Generate Slug from Title
                            <span></span>
                        </label>
                    </div>
                    <div class="form-group" v-show="generate_slug == 0">
                        <label>Slug</label>
                        <input type="text" class="form-control" v-model="slug">
                    </div>
                    <div class="form-group">
                        <label>State</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" value="1" name="enabled" required> Enabled
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" v-model="enabled" value="0" name="enabled" required> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
    new Vue({
        el: '#kt_content',
        data: {
            name: '',
            slug: '',
            enabled: '1',
            generate_slug: '1',
        },
        methods: {
            submitForm(event) {
                console.log(event);
                KTApp.block('body');
                axios.post(event.target.action, this.$data)
                .then(response => {
                    swal.fire({
                        title: response.data.title,
                        html: response.data.message,
                        type: response.data.type
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
                    KTApp.unblock('body');
                });
            }
        }
    });
</script>
@endsection
