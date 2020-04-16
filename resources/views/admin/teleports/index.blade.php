@extends('layout')

@section('pagetitle', 'Teleport Manager')

@section('content')
<div class="row no-gutters">
    <div class="col-xl-4 pr-md-2">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Teleport Points</h5>
            </div>
            <div class="card-body bg-light">
                <input type="search" class="form-control" v-model="search_in_teleport_points" placeholder="Search in Teleport Points">
                <select class="custom-select" size="35" v-model="selected_teleport_point">
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
    <div class="col-xl-8 pl-xxl-2" v-show="selected_teleport_point">
        <div class="card mb-3">
            <div class="card-header">
                <template v-if="selected_teleport_point.ID">
                    Edit Teleport Point: @{{ selected_teleport_point.obj_name }} (@{{ selected_teleport_point.zone_name }})
                </template>
                <template v-else>
                    Create New Teleport Point
                </template>
            </div>
            <div class="card-body">
                <teleport-point-form v-bind:teleport_point="selected_teleport_point"></teleport-point-form>
            </div>
        </div>
    </div>
</div>

<div class="row no-gutters" v-show="selected_teleport_point && selected_teleport_point.ID">
    <div class="col-xl-4 pr-md-2">
        <div class="card mb-3">
            <div class="card-header">
                Teleport Links
            </div>
            <div class="card-body">
                <select class="custom-select" size="30" v-model="selected_teleport_link">
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
    <div class="col-xl-8 pl-xxl-2" v-show="selected_teleport_link">
        <div class="card mb-3">
            <div class="card-header">
                <template v-if="selected_teleport_link.ID">
                    Edit Teleport Link: @{{ selected_teleport_link.owner_obj_name }} <--> (@{{ selected_teleport_link.target_obj_name }})
                </template>
                <template v-else>
                    Create New Teleport Link
                </template>
            </div>
            <div class="card-body">
                <teleport-link-form v-bind:teleport_link="selected_teleport_link"></teleport-link-form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
Vue.component('teleport-point-form', {
    props: ['teleport_point'],
    template: `
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="tp_codename128">CodeName128</label>
                <input class="form-control" id="tp_codename128" v-model.trim="teleport_point.CodeName128" required>
            </div>
            <div class="form-group">
                <label for="tp_assocrefobjid">Assoc Ref Object</label>
                <select class="custom-select" id="tp_assocrefobjid" v-model="teleport_point.AssocRefObjID" size="15" required>
                    <option value="0">- none -</option>
                    <option v-for="structure in filtered_structures" :value="structure.ID" v-bind:class="{'alert-danger' : structure.Service == 0}">
                        @{{ structure.CodeName128 }} (@{{ structure.name }}) - [@{{ structure.AssocFileObj128 }}]
                    </option>
                </select>
                <input type="search" class="form-control" v-model="search" placeholder="Search in Structures...">
            </div>
            <div class="form-group">
                <label for="tp_zonename">Zone Name</label>
                <input class="form-control" id="tp_zonename" v-model.trim="teleport_point.ZoneName128" required>
            </div>
            <div class="form-group">
                <label for="tp_genarearadius">GenAreaRadius</label>
                <input class="form-control" id="tp_genarearadius" v-model.number.trim="teleport_point.GenAreaRadius" required>
            </div>
            <div class="form-group">
                <label for="tp_fixedservice">FixedService</label>
                <input class="form-control" id="tp_fixedservice" v-model.number.trim="teleport_point.FixedService" required>
            </div>
            <div class="form-group">
                <div class="row col-12">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="tp_canberesurrectpos" type="checkbox" true-value="1" false-value="0" class="custom-control-input" v-model.number="teleport_point.CanBeResurrectPos">
                        <label for="tp_canberesurrectpos" class="custom-control-label">Can Be Resurrect Position</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input id="tp_cangotoresurrect" type="checkbox" true-value="1" false-value="0" class="custom-control-input" v-model.number="teleport_point.CanGotoResurrectPos">
                        <label for="tp_cangotoresurrect" class="custom-control-label">Can Goto Resurrect Position</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_service_true" v-model="teleport_point.Service" value="1"/>
                        <label for="tp_service_true" class="custom-control-label">Enabled</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_service_false" v-model="teleport_point.Service" value="0"/>
                        <label for="tp_service_false" class="custom-control-label">Disabled</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>Position Selection Type</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_position_false" v-model="position" value="0"/>
                        <label for="tp_position_false" class="custom-control-label">Manuel</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_position_true" v-model="position" value="1"/>
                        <label for="tp_position_true" class="custom-control-label">Character Position</label>
                    </div>
                </div>
            </div>
            <div class="form-group" v-if="position == 1">
                <label for="tp_charactername">Character Name:</label>
                <div class="input-group">
                    <div class="input-prepend">
                        <button class="btn btn-falcon-primary btn-block" @click="update_position" :disabled="character_position_updated || !character_name">Update</button>
                    </div>
                    <input id="tp_charactername" class="form-control" v-model.trim="character_name">
                </div>
            </div>
            <div class="form-group" v-else>
                <label for="tp_genreegionid">GenRegionID</label>
                <input id="tp_genreegionid" class="form-control" v-model.number.trim="teleport_point.GenRegionID">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="tp_genposx">GenPos_X</label>
                <input id="tp_genposx" class="form-control" v-model.number.trim="teleport_point.GenPos_X">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="tp_genposy">GenPos_Y</label>
                <input id="tp_genposy" class="form-control" v-model.number.trim="teleport_point.GenPos_Y">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="tp_genposz">GenPos_Z</label>
                <input id="tp_genposz" class="form-control" v-model.number.trim="teleport_point.GenPos_Z">
            </div>
            <div class="form-group" v-show="position == 0">
                <label for="tp_genworldid">GenWorldID</label>
                <input id="tp_genworldid" class="form-control" v-model.number.trim="teleport_point.GenWorldID">
            </div>
            <div class="form-group">
                <label>Bind Interaction Mask</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_bindinteractionmask_true" v-model="teleport_point.BindInteractionMask" value="1"/>
                        <label for="tp_bindinteractionmask_true" class="custom-control-label">Click Object</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tp_bindinteractionmask_false" v-model="teleport_point.BindInteractionMask" value="0"/>
                        <label for="tp_bindinteractionmask_false" class="custom-control-label">Move</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group ml-3" role="group">
            <button type="button" class="btn btn-falcon-primary" @click="updateTeleportPoint" :disabled="IsBeingUpdated">
                <template v-if="IsItCreateForm">
                Create
                </template>
                <template v-else>
                Update
                </template>
            </button>
            <button type="button" class="btn btn-falcon-danger" @click="deleteTeleportPoint" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
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
            $('.content').block();
            this.IsBeingUpdated = true;

            axios.post(this.$root.get_character_position_route, {
                character: this.character_name
            }).then(response => {
                this.teleport_point.GenRegionID = response.data.RegionId;
                this.teleport_point.GenPos_X = parseInt(response.data.PosX);
                this.teleport_point.GenPos_Y = parseInt(response.data.PosY);
                this.teleport_point.GenPos_Z = parseInt(response.data.PosZ);
                this.teleport_point.GenWorldID = response.data.WorldId;
                this.position = 0;

                swal.fire({
                    title: response.data.title,
                    html: response.data.message,
                    icon: response.data.icon
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
                $('.content').unblock();
                this.IsBeingUpdated = false;
            });
        },
        updateTeleportPoint() {
            this.IsBeingUpdated = true;
            $('.content').block();

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
                        $('.content').block();
                        this.IsBeingDeleted = true;

                        axios.post(this.$root.destroy_teleport_point_route, {
                            id: this.teleport_point.ID
                        }).then(response => {
                            this.$root.teleport_points.splice(this.$root.teleport_points.indexOf(this.teleport_point), 1);
                            this.$root.selected_teleport_point = '';
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

Vue.component('teleport-link-form', {
    props: ['teleport_link'],
    template: `
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="tl_ownerteleport">Owner Teleport (Teleport Source)</label>
                <select id="tl_ownerteleport" class="custom-select" v-model="teleport_link.OwnerTeleport" size="15" required>
                    <option v-for="teleport in filteredOwnerTeleports" :value="teleport.ID" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                        [@{{ teleport.CodeName128 }}] @{{ teleport.obj_name }} (@{{ teleport.zone_name }})
                    </option>
                </select>
                <input type="search" class="form-control" v-model="search_ownerteleports" placeholder="Search...">
            </div>
            <div class="form-group">
                <label for="tl_fee">Teleport Fee</label>
                <input id="tl_fee" type="number" class="form-control" v-model.number.trim="teleport_link.Fee" required>
            </div>
            <div class="form-group">
                <label for="tl_restrictbindmethod">Restrict Bind Method</label>
                <input id="tl_restrictbindmethod" type="text" class="form-control" v-model.number.trim="teleport_link.RestrictBindMethod" required>
            </div>
            <div class="form-group">
                <label for="tl_runtimeteleportmethod">Run Time Teleport Method</label>
                <input id="tl_runtimeteleportmethod" type="text" class="form-control" v-model.number.trim="teleport_link.RunTimeTeleportMethod" required>
            </div>
            <div class="form-group">
                <label for="tl_checkresult">Check Result</label>
                <input id="tl_checkresult" type="text" class="form-control" v-model.number.trim="teleport_link.CheckResult" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="row col-12">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tl_service_true" v-model="teleport_link.Service" value="1"/>
                        <label for="tl_service_true" class="custom-control-label">Enabled</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="tl_service_false" v-model="teleport_link.Service" value="0"/>
                        <label for="tl_service_false" class="custom-control-label">Disabled</label>
                    </div>
                </div>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-falcon-primary" @click="updateTeleportLink" :disabled="IsBeingUpdated">
                    <template v-if="IsItCreateForm">
                    Create
                    </template>
                    <template v-else>
                    Update
                    </template>
                </button>
                <button type="button" class="btn btn-falcon-danger" @click="deleteTeleportLink" v-show="!IsItCreateForm" :disabled="IsBeingDeleted">Delete</button>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="tl_targetteleport">Target Teleport (Teleport Target)</label>
                <select id="tl_targetteleport" class="custom-select" v-model="teleport_link.TargetTeleport" size="15" required>
                    <option v-for="teleport in filteredTargetTeleports" :value="teleport.ID" v-bind:class="{'alert-danger' : teleport.Service == 0}">
                        [@{{ teleport.CodeName128 }}] @{{ teleport.obj_name }} (@{{ teleport.zone_name }})
                    </option>
                </select>
                <input type="search" class="form-control" v-model="search_targetteleports" placeholder="Search...">
            </div>
            <div class="form-group">
                <label for="tl_restrict1">Restrict 1</label>
                <input id="tl_restrict1" type="text" class="form-control" v-model.number.trim="teleport_link.Restrict1" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict1 != 0">
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data1_1">Data 1_1</label>
                        <input id="tl_data1_1" type="text" class="form-control" v-model.number.trim="teleport_link.Data1_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data1_2">Data 1_2</label>
                        <input id="tl_data1_2" type="text" class="form-control" v-model.number.trim="teleport_link.Data1_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tl_restrict2">Restrict 2</label>
                <input id="tl_restrict2" type="text" class="form-control" v-model.number.trim="teleport_link.Restrict2" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict2 != 0">
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data2_1">Data 2_1</label>
                        <input id="tl_data2_1" type="text" class="form-control" v-model.number.trim="teleport_link.Data2_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data2_2">Data 2_2</label>
                        <input id="tl_data2_2" type="text" class="form-control" v-model.number.trim="teleport_link.Data2_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tl_restrict3">Restrict 3</label>
                <input id="tl_restrict3" type="text" class="form-control" v-model.number.trim="teleport_link.Restrict3" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict3 != 0">
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data3_1">Data 3_1</label>
                        <input id="tl_data3_1" type="text" class="form-control" v-model.number.trim="teleport_link.Data3_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data3_2">Data 3_2</label>
                        <input id="tl_data3_2" type="text" class="form-control" v-model.number.trim="teleport_link.Data3_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tl_restrict4">Restrict 4</label>
                <input id="tl_restrict4" type="text" class="form-control" v-model.number.trim="teleport_link.Restrict4" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict4 != 0">
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data4_1">Data 4_1</label>
                        <input id="tl_data4_1" type="text" class="form-control" v-model.number.trim="teleport_link.Data4_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data4_2">Data 4_2</label>
                        <input id="tl_data4_2" type="text" class="form-control" v-model.number.trim="teleport_link.Data4_2">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="tl_restrict5">Restrict 5</label>
                <input id="tl_restrict5" type="text" class="form-control" v-model.number.trim="teleport_link.Restrict5" required>
            </div>
            <div class="form-group row" v-show="teleport_link.Restrict5 != 0">
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data5_1">Data 5_1</label>
                        <input id="tl_data5_1" type="text" class="form-control" v-model.number.trim="teleport_link.Data5_1">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="tl_data5_2">Data 5_2</label>
                        <input id="tl_data5_2" type="text" class="form-control" v-model.number.trim="teleport_link.Data5_2">
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
            $('.content').block();
            this.IsBeingUpdated = true;

            axios.post(this.$root.update_teleport_link_route, this.teleport_link)
            .then(response => {
                if (this.IsItCreateForm) {
                    this.$root.selected_teleport_point.teleport_links.push(response.data.teleport_link);
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
                        $('.content').block();
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
