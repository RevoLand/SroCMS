@extends('layout')

@section('pagetitle', 'Reverse Point Manager')

@section('content')
<div class="row no-gutters">
    <div class="col-xl-4 pr-md-2">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Reverse Points</h5>
            </div>
            <div class="card-body bg-light">
                <input type="search" class="form-control" v-model="search_in_reverse_points" placeholder="Search in Reverse Points">
                <select class="custom-select" size="30" v-model="selected_reverse_point">
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
    <div class="col-xl-8 pl-xxl-2" v-show="selected_reverse_point">
        <div class="card mb-3">
            <div class="card-header">
                <template v-if="selected_reverse_point.ID">
                    Edit Reverse Point: @{{ selected_reverse_point.ObjName128 }} (@{{ selected_reverse_point.ZoneName128 }})
                </template>
                <template v-else>
                    Create New Reverse Point
                </template>
            </div>
            <div class="card-body">
                <reverse-point-form v-bind:reverse="selected_reverse_point"></reverse-point-form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
Vue.component('reverse-point-form', {
    props: ['reverse'],
    template: `
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="objname128">ObjName</label>
                <input id="objname128" class="form-control" v-model.trim="reverse.ObjName128" required>
            </div>
            <div class="form-group">
                <label for="zonename">Zone Name</label>
                <input id="zonename" class="form-control" v-model.trim="reverse.ZoneName128" required>
            </div>
            <div class="form-group">
                <label for="minlevel">Min Level</label>
                <input id="minlevel" class="form-control" v-model.number.trim="reverse.LevelMin" required>
            </div>
            <div class="form-group">
                <label for="maxlevel">Max Level</label>
                <input id="maxlevel" class="form-control" v-model.number.trim="reverse.LevelMax" required>
            </div>
            <div class="form-group">
                <label fpr="regionidgroup">RegionID Group</label>
                <input id="regionidgroup" class="form-control" v-model.number.trim="reverse.RegionIDGroup">
            </div>
            <div class="form-group">
                <label>Map Point</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="mappoint_true" v-model="reverse.MapPoint" value="1"/>
                        <label for="mappoint_true" class="custom-control-label">Yes</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="mappoint_false" v-model="reverse.MapPoint" value="0"/>
                        <label for="mappoint_false" class="custom-control-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="service_true" v-model="reverse.Service" value="1"/>
                        <label for="service_true" class="custom-control-label">Enabled</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="service_false" v-model="reverse.Service" value="0"/>
                        <label for="service_false" class="custom-control-label">Disabled</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Position Selection Type</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="position_false" v-model="position" value="0"/>
                        <label for="position_false" class="custom-control-label">Manuel</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="position_true" v-model="position" value="1"/>
                        <label for="position_true" class="custom-control-label">Character Position</label>
                    </div>
                </div>
            </div>
            <div class="form-group" v-if="position == 1">
                <label for="charactername">Character Name:</label>
                <div class="input-group">
                    <div class="input-prepend">
                        <button class="btn btn-falcon-primary btn-block" @click="update_position" :disabled="character_position_updated || !character_name">Update</button>
                    </div>
                    <input id="charactername" class="form-control" v-model.trim="character_name">
                </div>
            </div>
            <div class="form-group" v-else>
                <label for="regionid">RegionID</label>
                <input id="regionid" class="form-control" v-model.number.trim="reverse.RegionID">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="posx">Pos_X</label>
                <input id="posx" class="form-control" v-model.number.trim="reverse.Pos_X">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="posy">Pos_Y</label>
                <input id="posy" class="form-control" v-model.number.trim="reverse.Pos_Y">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="posz">Pos_Z</label>
                <input id="posz" class="form-control" v-model.number.trim="reverse.Pos_Z">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="worldid">WorldID</label>
                <input id="worldid" class="form-control" v-model.number.trim="reverse.WorldID">
            </div>
            <div class="form-group">
                <label for="param1">Param1</label>
                <input id="param1" class="form-control" v-model.number.trim="reverse.Param1">
            </div>
            <div class="form-group" v-show="reverse.Param1 != -1">
                <label for="param1_desc">Param1_Desc_128</label>
                <input id="param1_desc" class="form-control" v-model.number.trim="reverse.Param1_Desc_128">
            </div>
            <div class="form-group">
                <label for="param2">Param2</label>
                <input id="param2" class="form-control" v-model.number.trim="reverse.Param2">
            </div>
            <div class="form-group" v-show="reverse.Param2 != -1">
                <label for="param2_desc">Param2_Desc_128</label>
                <input id="param2_desc" class="form-control" v-model.number.trim="reverse.Param2_Desc_128">
            </div>
            <div class="form-group">
                <label for="param3">Param3</label>
                <input id="param3" class="form-control" v-model.number.trim="reverse.Param3">
            </div>
            <div class="form-group" v-show="reverse.Param3 != -1">
                <label for="param3_desc">Param3_Desc_128</label>
                <input id="param3_desc" class="form-control" v-model.number.trim="reverse.Param3_Desc_128">
            </div>
        </div>
        <div class="btn-group ml-3" role="group">
            <button type="button" class="btn btn-falcon-primary" @click="updateReversePoint" :disabled="IsBeingUpdated">
                <template v-if="IsItCreateForm">
                Create
                </template>
                <template v-else>
                Update
                </template>
            </button>
            <button type="button" class="btn btn-falcon-danger" @click="deleteReversePoint" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
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
            $('.content').block();
            this.IsBeingUpdated = true;

            axios.post(this.$root.get_character_position_route, {
                character: this.character_name
            }).then(response => {
                this.reverse.RegionID = response.data.RegionId;
                this.reverse.Pos_X = parseInt(response.data.PosX);
                this.reverse.Pos_Y = parseInt(response.data.PosY);
                this.reverse.Pos_Z = parseInt(response.data.PosZ);
                this.reverse.WorldID = response.data.WorldId;
                this.position = 0;

                this.character_position_updated = true;
                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    icon: response.data.icon
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
                $('.content').unblock();
                this.IsBeingUpdated = false;
            });
        },
        updateReversePoint() {
            this.IsBeingUpdated = true;
            $('.content').block();

            axios.post(this.$root.update_reverse_point_route, this.reverse)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.reverse_points.push(response.data.reverse_point);
                    this.$root.selected_reverse_point = response.data.reverse_point;
                }

                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    icon: response.data.icon
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
                $('.content').unblock();
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
                        $('.content').block();
                        this.IsBeingDeleted = true;

                        axios.post(this.$root.destroy_reverse_point_route, {
                            id: this.reverse.ID
                        }).then(response => {
                            this.$root.reverse_points.splice(this.$root.reverse_points.indexOf(this.reverse), 1);
                            this.$root.selected_reverse_point = '';
                            swal.fire({
                                title: response.data.title,
                                html: response.data.message,
                                icon: response.data.icon
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
                            $('.content').unblock();
                            this.IsBeingDeleted = false;
                        });
                    }
                }
            );
        }
    }
});

new Vue({
    el: '.content',
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
