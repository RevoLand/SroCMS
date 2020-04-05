@extends('layout')

@section('pagetitle', 'Reverse Point Manager')

@section('content')
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Reverse Point Manager</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.teleports.index') }}" class="kt-subheader__breadcrumbs-link">Teleports</a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.teleports.reverse_points.index') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Reverse Point Manager</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid reverse_points">

        <div class="row">
            <div class="col-xl-4">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Reverse Points
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <input type="search" class="form-control" v-model="search_in_reverse_points" placeholder="Search in Reverse Points">
                        <select class="form-control" size="35" v-model="selected_reverse_point">
                            <option value="" v-show="false"></option>
                            <option :value="{
                                Service: 1,
                                ZoneName128: 'xxx',
                                RegionIDGroup: -1,
                                MapPoint: 1,
                                LevelMin: 0,
                                LevelMax: 0,
                                Param1: -1,
                                Param1_Desc_128: 'xxx',
                                Param2: -1,
                                Param2_Desc_128: 'xxx',
                                Param3: -1,
                                Param3_Desc_128: 'xxx'
                            }">Create New</option>
                            <optgroup label="Existing Reverse Points">
                                <option v-for="reversePoint in filteredReversePoints" :value="reversePoint" v-bind:class="{'alert-danger': reversePoint.Service == 0, 'alert-warning': reversePoint.RegionIDGroup != -1}">
                                    [@{{ reversePoint.ID }}] @{{ reversePoint.ObjName128 }}  (Zone: @{{ reversePoint.zone_name }}) <template v-if="reversePoint.RegionIDGroup != -1">[Group: @{{ reversePoint.RegionIDGroup }}]</template>
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-8" v-show="selected_reverse_point">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selected_reverse_point.ID">
                                    Edit Reverse Point: @{{ selected_reverse_point.ObjName128 }} (@{{ selected_reverse_point.ZoneName128 }})
                                </template>
                                <template v-else>
                                    Create New Reverse Point
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <reverse-point-form v-bind:reverse="selected_reverse_point"></reverse-point-form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Container-->
    </div>

    <!-- end:: Content -->
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
Vue.component('reverse-point-form', {
    props: ['reverse'],
    template: `
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>ObjName</label>
                <input class="form-control" v-model.trim="reverse.ObjName128" required>
            </div>
            <div class="form-group">
                <label>Zone Name</label>
                <input class="form-control" v-model.trim="reverse.ZoneName128" required>
            </div>
            <div class="form-group">
                <label>Min Level</label>
                <input class="form-control" v-model.number.trim="reverse.LevelMin" required>
            </div>
            <div class="form-group">
                <label>Max Level</label>
                <input class="form-control" v-model.number.trim="reverse.LevelMax" required>
            </div>
            <div class="form-group">
                <label>RegionID Group</label>
                <input class="form-control" v-model.number.trim="reverse.RegionIDGroup">
            </div>
            <div class="form-group">
                <label>Map Point</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio">
                        <input type="radio" v-model="reverse.MapPoint" value="1"> Yes
                        <span></span>
                    </label>
                    <label class="kt-radio">
                        <input type="radio" v-model="reverse.MapPoint" value="0"> No
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>State</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio">
                        <input type="radio" v-model="reverse.Service" value="1"> Enabled
                        <span></span>
                    </label>
                    <label class="kt-radio">
                        <input type="radio" v-model="reverse.Service" value="0"> Disabled
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Position Selection Type:</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio">
                        <input type="radio" v-model="position" value="0"> Manuel
                        <span></span>
                    </label>
                    <label class="kt-radio">
                        <input type="radio" v-model="position" value="1"> Character Position
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="form-group" v-if="position == 1">
                <label>Character Name:</label>
                <div class="input-group">
                    <div class="input-prepend">
                        <button class="btn btn-primary btn-block" @click="update_position" :disabled="character_position_updated || !character_name">Update</button>
                    </div>
                    <input class="form-control" v-model.trim="character_name">
                </div>
            </div>
            <div class="form-group" v-else>
                <label>RegionID</label>
                <input class="form-control" v-model.number.trim="reverse.RegionID">
            </div>
            <div class="form-group" v-show="position == 0">
                <label>Pos_X</label>
                <input class="form-control" v-model.number.trim="reverse.Pos_X">
            </div>
            <div class="form-group" v-show="position == 0">
                <label>Pos_Y</label>
                <input class="form-control" v-model.number.trim="reverse.Pos_Y">
            </div>
            <div class="form-group" v-show="position == 0">
                <label>Pos_Z</label>
                <input class="form-control" v-model.number.trim="reverse.Pos_Z">
            </div>
            <div class="form-group" v-show="position == 0">
                <label>WorldID</label>
                <input class="form-control" v-model.number.trim="reverse.WorldID">
            </div>
            <div class="form-group">
                <label>Param1</label>
                <input class="form-control" v-model.number.trim="reverse.Param1">
            </div>
            <div class="form-group" v-show="reverse.Param1 != -1">
                <label>Param1_Desc_128</label>
                <input class="form-control" v-model.number.trim="reverse.Param1_Desc_128">
            </div>
            <div class="form-group">
                <label>Param2</label>
                <input class="form-control" v-model.number.trim="reverse.Param2">
            </div>
            <div class="form-group" v-show="reverse.Param2 != -1">
                <label>Param2_Desc_128</label>
                <input class="form-control" v-model.number.trim="reverse.Param2_Desc_128">
            </div>
            <div class="form-group">
                <label>Param3</label>
                <input class="form-control" v-model.number.trim="reverse.Param3">
            </div>
            <div class="form-group" v-show="reverse.Param3 != -1">
                <label>Param3_Desc_128</label>
                <input class="form-control" v-model.number.trim="reverse.Param3_Desc_128">
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col kt-align-left">
                        <button type="submit" class="btn btn-primary" @click="updateReversePoint" :disabled="IsBeingUpdated" v-bind:class="{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light': IsBeingUpdated }">
                            <template v-if="IsItCreateForm">
                            Create
                            </template>
                            <template v-else>
                            Update
                            </template>
                        </button>
                        <button type="button" class="btn btn-danger" @click="deleteReversePoint" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    `,
    data() {
        return {
            search: '',
            character_name: '',
            position: 1,
            character_position_updated: false,
            IsBeingUpdated: false,
            IsBeingDeleted: false
        }
    },
    computed: {
        IsItCreateForm() {
            return !(this.reverse.ID);
        }
    },
    watch: {
        character_name : function(newVal, oldVal) {
            this.character_position_updated = false;
        },
        reverse: function(newVal, oldVal) {
            this.character_position_updated = false;
            this.IsBeingUpdated = false;
            this.IsBeingDeleted = false;
        }
    },
    methods: {
        update_position() {
            KTApp.block('body');
            this.IsBeingUpdated = true;

            axios.post(this.$root.get_character_position_route, {
                character: this.character_name
            }).then(response => {
                this.reverse.RegionID = response.data.RegionId;
                this.reverse.Pos_X = parseInt(response.data.PosX);
                this.reverse.Pos_Y = parseInt(response.data.PosY);
                this.reverse.Pos_Z = parseInt(response.data.PosZ);
                this.reverse.WorldID = response.data.WorldId;

                this.character_position_updated = true;
                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    type: response.data.type
                });
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
        updateReversePoint() {
            this.IsBeingUpdated = true;
            KTApp.block('body');

            axios.post(this.$root.update_reverse_point_route, this.reverse)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.reverse_points.push(response.data.reverse_point);
                    this.$root.selected_reverse_point = response.data.reverse_point;
                }

                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    type: response.data.type
                });
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
        deleteReversePoint() {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        KTApp.block('body');
                        this.IsBeingDeleted = true;

                        axios.post(this.$root.destroy_reverse_point_route, {
                            id: this.reverse.ID
                        }).then(response => {
                            this.$root.reverse_points.splice(this.$root.reverse_points.indexOf(this.reverse), 1);
                            this.$root.selected_reverse_point = '';
                            swal.fire({
                                title: response.data.title,
                                html: response.data.message,
                                type: response.data.type
                            });
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
            );
        }
    }
});
new Vue({
    el: '.reverse_points',
    data: {
        reverse_points: [],
        search_in_reverse_points: '',
        selected_reverse_point: '',

        // routes
        get_character_position_route: @json(route('admin.characters.get_position')),
        update_reverse_point_route: @json(route('admin.teleports.reverse_points.update')),
        destroy_reverse_point_route: @json(route('admin.teleports.reverse_points.destroy'))
    },
    mounted() {
        this.reverse_points = @json($reversePoints);
    },
    computed: {
        filteredReversePoints() {
            return this.reverse_points.filter(point => {
                return point.ObjName128.toLowerCase().includes(this.search_in_reverse_points.toLowerCase())
                    || point.ZoneName128.toLowerCase().includes(this.search_in_reverse_points.toLowerCase())
                    || point.zone_name.toLowerCase().includes(this.search_in_reverse_points.toLowerCase());
            });
        }
    }
});
</script>
@endsection
