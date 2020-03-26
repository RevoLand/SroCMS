@extends('layout')

@section('pagetitle', 'Teleport Manager')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
    <!-- begin:: Subheader -->
    <div class="kt-subheader   kt-grid__item" id="kt_subheader">
        <div class="kt-container  kt-container--fluid ">
            <div class="kt-subheader__main">
                <h3 class="kt-subheader__title">Teleport Manager</h3>
                <span class="kt-subheader__separator kt-hidden"></span>
                <div class="kt-subheader__breadcrumbs">
                    <a href="{{ route('admin.dashboard.index') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                    <span class="kt-subheader__breadcrumbs-separator"></span>
                    <a href="{{ route('admin.teleports.index') }}" class="kt-subheader__breadcrumbs-link kt-subheader__breadcrumbs-link--active">Teleport Manager</a>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Subheader -->
    <!-- begin:: Content -->
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid">

        <div class="row teleport_points">
            <div class="col-xl-6">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Teleport Points
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
                        <select class="form-control" id="type" name="type" size="30" v-model="selected_teleport_point">
                            <option :value="{
                                Service: 1,
                                CanBeResurrectPos: 0,
                                CanGotoResurrectPos: 0,
                                BindInteractionMask: 1,
                                FixedService: 0
                            }">Create New</option>
                            <optgroup label="Existing Teleport Points">
                                <option v-for="teleport in filteredTeleportPoints" :value="teleport" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                                    [@{{ teleport.ID }}] @{{ teleport.CodeName128 }}  (Zone: @{{ teleport.zone_name }} - Obj: @{{ teleport.obj_name }})
                                </option>
                            </optgroup>
                        </select>
                        <input type="search" class="form-control" v-model="search" placeholder="Search in Teleport Points">
                    </div>
                </div>
            </div>
            <div class="col-xl-6" v-show="selected_teleport_point">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selected_teleport_point.ID">
                                    Edit Teleport Point: @{{ selected_teleport_point.obj_name }} (@{{ selected_teleport_point.zone_name }})
                                </template>
                                <template v-else>
                                    Create New Teleport Point
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body" v-if="selected_teleport_point">
                        <teleport-point-form v-bind:teleport_point="selected_teleport_point"></teleport-point-form>
                    </div>
                </div>
            </div>
        </div>

        <!-- end:: Container-->
    </div>

    <!-- end:: Content -->
</div>
@endsection

@section('js')
<script src="{{ asset('vendor/vue/vue.js') }}"></script>
<script src="{{ asset('vendor/axios.min.js') }}"></script>
<script>
Vue.component('teleport-point-form', {
    props: ['teleport_point'],
    template: `
    <div>
        <div class="form-group">
            <label>CodeName128</label>
            <input class="form-control" v-model.trim="teleport_point.CodeName128" required>
        </div>
        <div class="form-group">
            <label>Assoc Ref Object</label>
            <select class="form-control" v-model="teleport_point.AssocRefObjID" size="5" required>
                <option value="0">- none -</option>
                <option v-for="structure in filtered_structures" :value="structure.ID" v-bind:class="{'alert-danger' : structure.Service == 0}">
                    @{{ structure.CodeName128 }} (@{{ structure.name }}) - [@{{ structure.AssocFileObj128 }}]
                </option>
            </select>
            <input type="search" class="form-control" v-model="search" placeholder="Search in Structures...">
        </div>
        <div class="form-group">
            <label>Zone Name</label>
            <input class="form-control" v-model.trim="teleport_point.ZoneName128" required>
        </div>
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
            <label>GenRegionID</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenRegionID">
        </div>
        <div class="form-group" v-show="position == 0">
            <label>GenPos_X</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenPos_X">
        </div>
        <div class="form-group" v-show="position == 0">
            <label>GenPos_Y</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenPos_Y">
        </div>
        <div class="form-group" v-show="position == 0">
            <label>GenPos_Z</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenPos_Z">
        </div>
        <div class="form-group" v-show="position == 0">
            <label>GenWorldID</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenWorldID">
        </div>
        <div class="form-group">
            <label>GenAreaRadius</label>
            <input class="form-control" v-model.number.trim="teleport_point.GenAreaRadius" required>
        </div>
        <div class="form-group">
            <label class="kt-checkbox">
                <input type="checkbox" true-value="1" false-value="0" class="form-control" v-model.number="teleport_point.CanBeResurrectPos">
                Can Be Resurrect Position
                <span></span>
            </label>
        </div>
        <div class="form-group">
            <label class="kt-checkbox">
                <input type="checkbox" true-value="1" false-value="0" class="form-control" v-model.number="teleport_point.CanGotoResurrectPos">
                Can Goto Resurrect Position
                <span></span>
            </label>
        </div>
        <div class="form-group">
            <label>BindInteractionMask</label>
            <div class="kt-radio-inline">
                <label class="kt-radio">
                    <input type="radio" v-model="teleport_point.BindInteractionMask" value="1"> Click Object
                    <span></span>
                </label>
                <label class="kt-radio">
                    <input type="radio" v-model="teleport_point.BindInteractionMask" value="0"> Move
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <label>FixedService</label>
            <input class="form-control" v-model.number.trim="teleport_point.FixedService" required>
        </div>
        <div class="form-group">
            <label>State</label>
            <div class="kt-radio-inline">
                <label class="kt-radio">
                    <input type="radio" v-model="teleport_point.Service" value="1"> Enabled
                    <span></span>
                </label>
                <label class="kt-radio">
                    <input type="radio" v-model="teleport_point.Service" value="0"> Disabled
                    <span></span>
                </label>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col kt-align-left">
                        <button type="submit" class="btn btn-primary" @click="updateTeleportPoint" :disabled="IsBeingUpdated">
                            <template v-if="IsItCreateForm">
                            Create
                            </template>
                            <template v-else>
                            Update
                            </template>
                        </button>
                        <button type="button" class="btn btn-danger" @click="deleteTeleportPoint" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
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
            position: 0,
            character_position_updated: false,
            IsBeingUpdated: false,
            IsBeingDeleted: false
        }
    },
    computed: {
        filtered_structures() {
            return this.$root.teleport_structures.filter(structure => {
                return structure.CodeName128.toLowerCase().includes(this.search.toLowerCase())
                    || structure.AssocFileObj128.toLowerCase().includes(this.search.toLowerCase())
                    || structure.name.toLowerCase().includes(this.search.toLowerCase());
            });
        },
        IsItCreateForm() {
            return !(this.teleport_point.ID);
        }
    },
    watch: {
        'teleport_point.AssocRefObjID' : function(newVal, oldVal) {
            if (newVal == 0) {
                this.teleport_point.AssocRefObjCodeName128 = 'xxx';
                return;
            }

            let structure = this.$root.teleport_structures.find(structure => structure.ID == newVal);

            if (structure) {
                this.teleport_point.AssocRefObjCodeName128 = structure.CodeName128;
            }
        },
        character_name : function(newVal, oldVal) {
            this.character_position_updated = false;
        },
        teleport_point: function(newVal, oldVal) {
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
                this.teleport_point.GenRegionID = response.data.RegionId;
                this.teleport_point.GenPos_X = parseInt(response.data.PosX);
                this.teleport_point.GenPos_Y = parseInt(response.data.PosY);
                this.teleport_point.GenPos_Z = parseInt(response.data.PosZ);
                this.teleport_point.GenWorldID = response.data.WorldId;

                swal.fire( 'Updated!', response.data.message, 'success');
                this.character_position_updated = true;
            })
            .catch(error => {
                console.log(error.response);
                swal.fire( 'Error!', error.response.data.message, 'error');
            });

            this.IsBeingUpdated = false;
            KTApp.unblock('body');
        },
        updateTeleportPoint() {
            KTApp.block('body');
            this.IsBeingUpdated = true;

            axios.post(this.$root.update_teleport_point_route, this.teleport_point)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.teleport_points.push(response.data.teleport);
                    swal.fire( 'Created!', response.data.message, 'success');
                } else {
                    swal.fire( 'Updated!', response.data.message, 'success');
                }
            })
            .catch(error => {
                swal.fire('Error!', error.response.data.message, 'error');
            });

            this.IsBeingUpdated = false;
            KTApp.unblock('body');
        },
        deleteTeleportPoint() {
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

                        axios.post(this.$root.destroy_teleport_point_route, {
                            id: this.teleport_point.ID
                        }).then(response => {
                            this.$root.teleport_points.splice(this.$root.teleport_points.indexOf(this.teleport_point), 1);
                            this.$root.selected_teleport_point = '';
                            this.IsBeingDeleted = false;
                            swal.fire( 'Deleted!', response.data.message, 'success');
                        })
                        .catch(error => {
                            console.log(error.response);
                            alert(error.response.data.message);
                            this.IsBeingDeleted = false;
                        });
                        KTApp.unblock('body');
                    }
                }
            );
        }
    }
});

new Vue({
    el: '.teleport_points',
    data: {
        teleport_structures: [],

        teleport_points: [],
        search: '',

        selected_teleport_point: '',
        // routes
        get_character_position_route: '{{ route('admin.characters.get_position') }}',
        update_teleport_point_route: '{{ route('admin.teleports.update_point') }}',
        destroy_teleport_point_route: '{{ route('admin.teleports.destroy_point') }}'
    },
    mounted() {
        this.teleport_structures = @json($availableTeleportBuildings);
        this.teleport_points = @json($teleports);
    },
    computed: {
        filteredTeleportPoints() {
            return this.teleport_points.filter(point => {
                return point.CodeName128.toLowerCase().includes(this.search.toLowerCase())
                    || point.zone_name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    }
});
</script>
@endsection
