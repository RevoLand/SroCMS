@extends('layout')

@section('pagetitle', 'Menus')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Menus</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.pages.index') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Menus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid menus-vue">

        <div class="row">
            <div class="col-xl-3">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Menus
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-actions">
                                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                                    <i class="la la-edit"></i> Create New Menu
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <select class="form-control" id="type" name="type" size="10" v-model="selected_menu">
                            <option :value="{}">Create New Item</option>
                            <optgroup label="Existing Items">
                                <option v-for="menu in menus" :value="menu" v-bind:class="{'alert-danger' : menu.enabled == 0}">
                                    [@{{ menu.id }}] @{{ menu.name }}
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-9" v-show="selected_menu">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selected_menu.id">
                                    Edit Menu: @{{ selected_menu.name }}
                                </template>
                                <template v-else>
                                    Create New Menu
                                </template>
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-actions">
                                <a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-upper btn-sm btn-bold">
                                    <i class="la la-edit"></i> Create Menu Item
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__body" id="test">
                        <template v-if="selected_menu.id">
                            <menu-edit-form v-bind:menu_item="selected_menu"></menu-edit-form>
                        </template>
                        <template v-else>
                            <menu-form v-bind:menu="selected_menu"></menu-form>
                        </template>
                    </div>
                </div>
            </div>

        </div>

        <!-- end:: Container-->
    </div>

    <!-- end:: Content -->
</div>
@endsection

@section('css')

@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
Vue.component('menu-form', {
    props: ['menu'],
    template: `
    <div>
    </div>
    `,
});

Vue.component('menu-edit-form', {
    props: ['menu_item'],
    template: `
        <ul>
            <li v-for="element in menu_item.items" :key="element.id">
                @{{element.title}}
                <menu-child v-bind:menu_item="element"></menu-child>
            </li>
        </ul>
    `
});

Vue.component('menu-child', {
    props: ['menu_item'],
    template: `
    <ul>
        <li v-for="child in menu_item.childrens" :key="child.id">
            @{{ child.title }}
            <menu-child v-bind:menu_item="child"></menu-child>
        </li>
    </ul>
    `,
    mounted() {

    }
});
new Vue({
    el: '.menus-vue',
    data: {
        menus: [],
        selected_menu: ''
    },
    mounted() {
        this.menus = @json($menus)
    }
});
</script>
@endsection
