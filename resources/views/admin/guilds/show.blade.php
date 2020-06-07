@extends('layout')

@section('pagetitle', 'View Guild')

@section('content')
<div class="card mb-3">
    <div class="card-body position-relative">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-1" v-text="guild.Name"></h3>
                <h5 class="fs-0 font-weight-normal">Level: @{{ guild.Lvl }}</h5>
                <p class="fs-0 mb-0 font-weight-normal">Gathered SP: @{{ guild.GatheredSP | formatNumber }}</p>
                <p class="fs-0 font-weight-normal">Created At: @{{ guild.FoundationDate | formatDate }}</p>
                <a class="btn btn-falcon-primary btn-sm px-3" :href="route('users.guilds.show', guild.ID)">Public Profile</a>
                <hr class="border-dashed my-4 d-lg-none">
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header">
      <div class="row align-items-center justify-content-between">
        <div class="col-4 col-sm-auto d-flex align-items-center pr-0">
          <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Members</h5>
        </div>
      </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0 table-striped fs--1 border-bottom border-200">
                <thead class="bg-200 text-900">
                <tr>
                    <th class="align-middle sort">Name</th>
                    <th class="align-middle sort">Level</th>
                    <th class="align-middle sort">GP Donated</th>
                    <th class="align-middle sort">Member Class</th>
                    <th class="align-middle sort">Siege Authority</th>
                    <th class="align-middle sort">Permission(s)</th>
                    <th class="align-middle sort">Join Date</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="member in guild.members">
                        <td class="py-2 align-middle">
                            <a class="text-reset" :href="route('admin.characters.show', member.CharID)">
                                <div class="media d-flex align-items-center">
                                    <div class="avatar avatar-xl mr-2">
                                        <img class="rounded-circle" :src="GetCharacterImage(member.RefObjID)" alt="" />
                                      </div>
                                    <div class="media-body">
                                        <h5 class="mb-0 fs--1" v-text="member.CharName"></h5>
                                    </div>
                                </div>
                            </a>
                        </td>
                        <td class="py-2 align-middle" v-text="member.CharLevel"></td>
                        <td class="py-2 align-middle" v-text="member.GP_Donation"></td>
                        <td class="py-2 align-middle"><template v-if="member.MemberClass == 0">Master</template><template v-else>Member</template></td>
                        <td class="py-2 align-middle">@{{ siege_authority_names[member.SiegeAuthority] }}</td>
                        <td class="py-2 align-middle">@{{ GetPermissionNames(member.Permission) }}</td>
                        <td class="py-2 align-middle">@{{ member.JoinDate | formatDate }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    new Vue({
        el: '.content',
        data: {
            guild: @json($guild),
            siege_authority_names: @json(config('constants.guild.siege')),
            permission_names: @json(config('constants.guild.permission_names')),
            assets_base_url: @json(asset('vendor/img/silkroad/characters/')),
        },
        methods: {
            GetPermissionNames: function(permission) {
                let permNames = [];
                _.each(this.permission_names, function (value, key) {
                    if (key & permission && key != -1) {
                        permNames.push(value);
                    }
                })

                return permNames.join(', ');
            },
            GetCharacterImage: function(refObjID) {
                return `${this.assets_base_url}/${refObjID}.gif`;
            }
        },
    });
</script>
@endsection
