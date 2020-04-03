@extends('layout')

@section('pagetitle', 'Edit Category')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Edit Category</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.index') }}" class="kt-subheader__breadcrumbs-link">Articles</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.categories.index') }}" class="kt-subheader__breadcrumbs-link">Categories</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.articles.categories.edit', $category) }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Edit Category</a>
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
                        Edit Category
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-actions">
                        <a href="{{ route('articles.get_category', $category->slug) }}" class="btn btn-accent btn-upper btn-sm btn-bold">
                            <i class="la la-eye"></i> View Category
                        </a>
                        <a href="{{ route('admin.articles.categories.index') }}" class="btn btn-info btn-upper btn-sm btn-bold">
                            <i class="la la-copy"></i> List Categories
                        </a>
                        <a href="{{ route('admin.articles.categories.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                            <i class="la la-edit"></i> Create Category
                        </a>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">
                {{ Form::open(['route' => ['admin.articles.categories.update', $category], 'class' => 'kt-form', 'method' => 'patch', '@submit.prevent' => 'submitForm']) }}
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
                                <input type="radio" v-model="enabled" value="1" name="enabled" required> Disabled
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions kt-form__actions--right">
                            <div class="row">
                                <div class="col kt-align-left">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col kt-align-right">
                                    {!! Form::open([ 'route' => ['admin.articles.categories.destroy', $category], 'method' => 'delete', '@submit.prevent' => 'deleteForm']) !!}
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
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
    new Vue({
        el: '#kt_content',
        data: {
            name: @json($category->name),
            slug: @json($category->slug),
            enabled: @json($category->enabled),
            generate_slug: '0',
        },
        methods: {
            submitForm(event) {
                KTApp.block('body');
                axios.patch(event.target.action, this.$data)
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
            },
            deleteForm(event) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                    KTApp.block('body');

                    axios.delete(event.target.action)
                    .then(response => {
                        swal.fire({
                            title: response.data.title,
                            html: response.data.message,
                            type: response.data.type
                        }).then((result) => {
                            window.location.href = '{{ route('admin.articles.categories.index') }}'
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
            });
        }
        }
    });
</script>
@endsection
