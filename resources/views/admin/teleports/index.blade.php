@extends('layout')

@section('pagetitle', 'Teleport Manager')

@section('content')
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
    <div class="kt-container kt-container--fluid  kt-grid__item kt-grid__item--fluid teleport_points">

        <div class="row">
            <div class="col-xl-4">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Teleport Points
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <input type="search" class="form-control" v-model="search_in_teleport_points" placeholder="Search in Teleport Points">
                        <select class="form-control" size="35" v-model="selected_teleport_point">
                            <option value="" v-show="false"></option>
                            <option :value="{
                                Service: 1,
                                CanBeResurrectPos: 0,
                                CanGotoResurrectPos: 0,
                                BindInteractionMask: 1,
                                FixedService: 0,
                                ZoneName128: 'xxx',
                                GenAreaRadius: 50
                            }">Create New</option>
                            <optgroup label="Existing Teleport Points">
                                <option v-for="teleport in filteredTeleportPoints" :value="teleport" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                                    [@{{ teleport.ID }}] @{{ teleport.CodeName128 }}  (Zone: @{{ teleport.zone_name }} - Obj: @{{ teleport.obj_name }})
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-8" v-show="selected_teleport_point">
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

        <div class="row" v-show="selected_teleport_point && selected_teleport_point.ID">
            <div class="col-xl-4">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                Teleport Links
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body">
                        <select class="form-control" size="30" v-model="selected_teleport_link">
                            <option value="" v-show="false"></option>
                            <option :value="{
                                'Service': 1,
                                'OwnerTeleport': selected_teleport_point.ID,
                                'Fee': 0,
                                'RestrictBindMethod': 0,
                                'RunTimeTeleportMethod': 0,
                                'CheckResult': 0,
                                'Restrict1' : 0,
                                'Restrict2' : 0,
                                'Restrict3' : 0,
                                'Restrict4' : 0,
                                'Restrict5' : 0
                            }">Create New</option>
                            <optgroup label="Existing Teleport Links">
                                <option v-for="teleport_link in selected_teleport_point.teleport_links" :value="teleport_link" v-bind:class="{'alert-danger' : teleport_link.Service == 0}">
                                    [@{{ teleport_link.ID }}] Owner: @{{ teleport_link.owner_obj_name }} (@{{ teleport_link.owner_zone_name }}) - Target: @{{ teleport_link.target_obj_name }} (@{{ teleport_link.target_zone_name }})
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-8" v-show="selected_teleport_link">
                <div class="kt-portlet kt-portlet--mobile">
                    <div class="kt-portlet__head">
                        <div class="kt-portlet__head-label">
                            <h3 class="kt-portlet__head-title">
                                <template v-if="selected_teleport_link.ID">
                                    Edit Teleport Link: @{{ selected_teleport_link.owner_obj_name }} <--> (@{{ selected_teleport_link.target_obj_name }})
                                </template>
                                <template v-else>
                                    Create New Teleport Link
                                </template>
                            </h3>
                        </div>
                    </div>
                    <div class="kt-portlet__body" v-if="selected_teleport_link">
                        <teleport-link-form v-bind:teleport_link="selected_teleport_link"></teleport-link-form>
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
Vue.component('teleport-point-form', {
    props: ['teleport_point'],
    template: `
    <div class="row">
        <div class="col-6">
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
                <label>GenAreaRadius</label>
                <input class="form-control" v-model.number.trim="teleport_point.GenAreaRadius" required>
            </div>
            <div class="form-group">
                <label>FixedService</label>
                <input class="form-control" v-model.number.trim="teleport_point.FixedService" required>
            </div>
            <div class="form-group">
                <div class="kt-checkbox-inline">
                    <label class="kt-checkbox">
                        <input type="checkbox" true-value="1" false-value="0" class="form-control" v-model.number="teleport_point.CanBeResurrectPos">
                        Can Be Resurrect Position
                        <span></span>
                    </label>
                    <label class="kt-checkbox">
                        <input type="checkbox" true-value="1" false-value="0" class="form-control" v-model.number="teleport_point.CanGotoResurrectPos">
                        Can Goto Resurrect Position
                        <span></span>
                    </label>
                </div>
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
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <div class="row">
                    <div class="col kt-align-left">
                        <button type="submit" class="btn btn-primary" @click="updateTeleportPoint" :disabled="IsBeingUpdated" v-bind:class="{ 'kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light': IsBeingUpdated }">
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
            position: 1,
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

                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    type: response.data.type
                });
                this.character_position_updated = true;
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
        updateTeleportPoint() {
            this.IsBeingUpdated = true;
            KTApp.block('body');

            var postData = Object.assign({}, this.teleport_point);
            postData.teleport_links = undefined;

            axios.post(this.$root.update_teleport_point_route, postData)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.teleport_points.push(response.data.teleport);
                    this.$root.selected_teleport_point = response.data.teleport;
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

Vue.component('teleport-link-form', {
    props: ['teleport_link'],
    template: `
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>Owner Teleport (Teleport Source)</label>
                <select class="form-control" v-model="teleport_link.OwnerTeleport" size="15" required>
                    <option v-for="teleport in filteredOwnerTeleports" :value="teleport.ID" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                        [@{{ teleport.CodeName128 }}] @{{ teleport.obj_name }} (@{{ teleport.zone_name }})
                    </option>
                </select>
                <input type="search" class="form-control" v-model="search_ownerteleports" placeholder="Search...">
            </div>
            <div class="form-group">
                <label>Teleport Fee</label>
                <input type="number" class="form-control" v-model.number.trim="teleport_link.Fee" required>
            </div>
            <div class="form-group">
                <label>Restrict Bind Method</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.RestrictBindMethod" required>
            </div>
            <div class="form-group">
                <label>Run Time Teleport Method</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.RunTimeTeleportMethod" required>
            </div>
            <div class="form-group">
                <label>Check Result</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.CheckResult" required>
            </div>
            <div class="form-group">
                <label>State</label>
                <div class="kt-radio-inline">
                    <label class="kt-radio">
                        <input type="radio" v-model="teleport_link.Service" value="1"> Enabled
                        <span></span>
                    </label>
                    <label class="kt-radio">
                        <input type="radio" v-model="teleport_link.Service" value="0"> Disabled
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col kt-align-left">
                            <button type="submit" class="btn btn-primary" @click="updateTeleportLink" :disabled="IsBeingUpdated">
                                <template v-if="IsItCreateForm">
                                Create
                                </template>
                                <template v-else>
                                Update
                                </template>
                            </button>
                            <button type="button" class="btn btn-danger" @click="deleteTeleportLink" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Target Teleport (Teleport Target)</label>
                <select class="form-control" v-model="teleport_link.TargetTeleport" size="15" required>
                    <option v-for="teleport in filteredTargetTeleports" :value="teleport.ID" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                        [@{{ teleport.CodeName128 }}] @{{ teleport.obj_name }} (@{{ teleport.zone_name }})
                    </option>
                </select>
                <input type="search" class="form-control" v-model="search_targetteleports" placeholder="Search...">
            </div>
            <div class="form-group">
                <label>Restrict 1</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.Restrict1" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict1 != 0">
                <div class="col">
                    <div class="form-group">
                        <label>Data 1_1</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data1_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Data 1_2</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data1_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Restrict 2</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.Restrict2" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict2 != 0">
                <div class="col">
                    <div class="form-group">
                        <label>Data 2_1</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data2_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Data 2_2</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data2_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Restrict 3</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.Restrict3" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict3 != 0">
                <div class="col">
                    <div class="form-group">
                        <label>Data 3_1</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data3_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Data 3_2</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data3_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Restrict 4</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.Restrict4" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict4 != 0">
                <div class="col">
                    <div class="form-group">
                        <label>Data 4_1</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data4_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Data 4_2</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data4_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Restrict 5</label>
                <input type="text" class="form-control" v-model.number.trim="teleport_link.Restrict5" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict5 != 0">
                <div class="col">
                    <div class="form-group">
                        <label>Data 5_1</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data5_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label>Data 5_2</label>
                        <input type="text" class="form-control" v-model.number.trim="teleport_link.Data5_2">
                    </div>
                </div>
            </div>
        </div>
    </div>
    `,
    data() {
        return {
            search_ownerteleports: '',
            search_targetteleports: '',
            IsBeingUpdated: false,
            IsBeingDeleted: false
        }
    },
    computed: {
        filteredOwnerTeleports() {
            return this.$root.teleport_points.filter(point => {
                return point.CodeName128.toLowerCase().includes(this.search_ownerteleports.toLowerCase())
                    || point.obj_name.toLowerCase().includes(this.search_ownerteleports.toLowerCase())
                    || point.zone_name.toLowerCase().includes(this.search_ownerteleports.toLowerCase());
            });
        },
        filteredTargetTeleports() {
            return this.$root.teleport_points.filter(point => {
                return point.CodeName128.toLowerCase().includes(this.search_targetteleports.toLowerCase())
                    || point.obj_name.toLowerCase().includes(this.search_targetteleports.toLowerCase())
                    || point.zone_name.toLowerCase().includes(this.search_targetteleports.toLowerCase());
            });
        },
        IsItCreateForm() {
            return !(this.teleport_link.ID);
        }
    },
    methods: {
        updateTeleportLink() {
            KTApp.block('body');
            this.IsBeingUpdated = true;

            axios.post(this.$root.update_teleport_link_route, this.teleport_link)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.selected_teleport_point.teleport_links.push(response.data.teleport_link);
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
        deleteTeleportLink() {
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

                        axios.post(this.$root.destroy_teleport_link_route, {
                            id: this.teleport_link.ID
                        }).then(response => {
                            this.$root.selected_teleport_point.teleport_links.splice(this.$root.selected_teleport_point.teleport_links.indexOf(this.teleport_link), 1);
                            this.$root.selected_teleport_link = '';
                            this.IsBeingDeleted = false;
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
    el: '.teleport_points',
    data: {
        teleport_structures: [],

        teleport_points: [],
        search_in_teleport_points: '',

        selected_teleport_point: '',
        selected_teleport_link: '',

        // routes
        get_character_position_route: @json(route('admin.characters.get_position')),
        update_teleport_point_route: @json(route('admin.teleports.update')),
        destroy_teleport_point_route: @json(route('admin.teleports.destroy')),
        update_teleport_link_route: @json(route('admin.teleports.link.update')),
        destroy_teleport_link_route: @json(route('admin.teleports.link.destroy'))
    },
    mounted() {
        this.teleport_structures = @json($availableTeleportBuildings);
        this.teleport_points = @json($teleports);
    },
    computed: {
        filteredTeleportPoints() {
            return this.teleport_points.filter(point => {
                return point.CodeName128.toLowerCase().includes(this.search_in_teleport_points.toLowerCase())
                    || point.obj_name.toLowerCase().includes(this.search_in_teleport_points.toLowerCase())
                    || point.zone_name.toLowerCase().includes(this.search_in_teleport_points.toLowerCase());
            });
        }
    },
    watch: {
        selected_teleport_point: function(newVal, oldVal) {
            this.selected_teleport_link = '';
        }
    }
});
</script>
@endsection
