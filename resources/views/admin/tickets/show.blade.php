@extends('layout')

@section('content')
<div class="row" id="ticket_info">
    <div class="col-md-9 mb-3 mb-md-0">
        @include('components.errors')
        @include('components.message')
        <div class="card card-chat">
            <div class="card-body d-flex px-0 py-0">
                {{-- card body --}}
                <div class="card-chat-content fs--1 position-relative">
                    <div class="card-chat-pane">
                        <div class="chat-content-header">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-6 col-sm-8 d-flex align-items-center">
                                    <div class="min-w-0">
                                        <div class="media">
                                            <div v-if="ticket.user.gravatar" class="avatar avatar-2xl mr-3" :class="[ticket.user.online ? 'status-online' : 'status-offline']">
                                                <img class="rounded-circle" :src="ticket.user.gravatar" alt="" />
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mb-0 text-truncate fs-0"><a class="text-decoration-none text-700" :href="route('admin.users.show', ticket.user.JID)" v-text="ticket.user.StrUserID"></a></h5>
                                                <p class="mb-0" v-if="ticket.user.Name" v-text="ticket.user.Name"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-sm btn-falcon-primary btn-info" type="button" data-index="0" data-toggle="tooltip" data-placement="top" title="Conversation Information"><span class="fas fa-info"></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="chat-content-body" style="display: inherit;">
                            {{-- TODO: conversation info panel --}}
                            <div class="conversation-info" data-index="0">
                                <div class="h-100 overflow-auto scrollbar perfect-scrollbar">
                                    <div class="media position-relative align-items-center p-3 border-bottom">
                                        <div class="avatar avatar-xl" :class="[ticket.user.online ? 'status-online' : 'status-offline']" v-if="ticket.user.gravatar">
                                            <img class="rounded-circle" :src="ticket.user.gravatar" alt="" />
                                        </div>
                                        <div class="media-body ml-2 d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <a class="text-decoration-none stretched-link text-700" :href="route('admin.users.show', ticket.user.JID)" v-text="ticket.user.StrUserID"></a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="px-3 pt-2">
                                        <div class="nav flex-column text-sans-serif font-weight-medium">
                                            <a class="nav-link d-flex align-items-center py-1 px-0 text-600" href="#!">
                                                <span class="conversation-info-icon"><span class="fas fa-search mr-1" data-fa-transform="shrink-1 down-3"></span></span>Search in Conversation
                                            </a>
                                            <a class="nav-link d-flex align-items-center py-1 px-0 text-600" href="#!">
                                                <span class="conversation-info-icon"><span class="fas fa-pencil-alt mr-1" data-fa-transform="shrink-1"></span></span>Edit Nicknames
                                            </a>
                                            <a class="nav-link d-flex align-items-center py-1 px-0 text-600" href="#!">
                                                <span class="conversation-info-icon"><span class="fas fa-palette mr-1" data-fa-transform="shrink-1"></span></span><span>Change Color</span>
                                            </a>
                                            <a class="nav-link d-flex align-items-center py-1 px-0 text-600" href="#!">
                                                <span class="conversation-info-icon"><span class="fas fa-thumbs-up mr-1" data-fa-transform="shrink-1"></span></span>Change Emoji
                                            </a>
                                            <a class="nav-link d-flex align-items-center py-1 px-0 text-600" href="#!">
                                                <span class="conversation-info-icon"><span class="fas fa-bell mr-1" data-fa-transform="shrink-1"></span></span>Notifications
                                            </a>
                                        </div>
                                    </div>
                                    <hr class="my-2" />
                                    <div class="px-3" id="ticket-info">
                                        <div class="title" id="ticket-attachments-title">
                                            <a class="btn btn-link btn-accordion hover-text-decoration-none dropdown-indicator" href="#ticket-attachments" data-toggle="collapse" aria-expanded="false" aria-controls="ticket-attachments">
                                                Attachments
                                            </a>
                                        </div>
                                        <div class="collapse" id="ticket-attachments" aria-labelledby="ticket-attachments-title" data-parent="#ticket-info">
                                            <div class="row mx-n1">
                                                <template v-for="message in ticket.messages" v-key="message.id">
                                                    <div class="col-6 col-md-4 px-1" v-for="attachment in message.attachments">
                                                        <a :href="attachment.file_url" data-fancybox="attachments">
                                                            <img class="img-fluid rounded mb-2" :src="attachment.file_url" alt="" />
                                                        </a>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- /conversation info panel ends --}}
                            <div class="chat-content-scroll-area scrollbar">
                                <message-group v-for="(message_group, date) in grouped_ticket_messages" :key="date" :messages="message_group"></message-group>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- /card body ends --}}
            </div>
            <div class="row p-2">
                <div class="col-12">
                    {!! Form::open(['route' => ['admin.ticketmessages.store', $ticket], 'method' => 'POST', 'files' => true, '@submit.prevent' => 'submitReplyForm']) !!}
                    <div class="form-group">
                        <label for="editor">Reply</label>
                        <editor id="editor" :init="editorConfig" v-model="reply_form.message" />
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="ticket-file-upload">Choose file(s) to attach</label>
                                    <input v-on:change="handleReplyAttachments" class="custom-file-input" type="file" multiple name="attachments[]" accept="image/*" id="ticket-file-upload">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-falcon-primary btn-block" type="submit">Send</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-3" v-if="ticket">
            <div class="card-header">
                <h5 class="mb-0" v-text="ticket.title"></h5>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col">
                        <h5 class="fs-0">Created at</h5>
                        <p class="fs--1">@{{ ticket.created_at }}</p>
                    </div>
                    <div class="col">
                        <h5 class="fs-0">Latest Update</h5>
                        <p class="fs--1">@{{ ticket.updated_at }}</p>
                    </div>
                </div>
                <hr class="py-1">
                <div class="row">
                    <div class="col">
                        <h5 class="fs-0 pb-2">Status</h5>
                        <p class="fs--1" v-if="available_statuses">
                            <label class="btn btn-sm" :class="available_statuses[ticket.status].adminclass" v-html="available_statuses[ticket.status].name"></label>
                        </p>
                    </div>
                    <div class="col">
                        <h5 class="fs-0 pb-2">Priority</h5>
                        <p class="fs--1">
                            <label class="btn btn-sm" :class="available_priorities[ticket.priority].adminclass" v-html="available_priorities[ticket.priority].name"></label>
                        </p>
                    </div>
                </div>
                <hr class="py-1">
                <div class="row">
                    <div class="col">
                        <h5 class="fs-0">Order</h5>
                        <p class="fs--1" v-if="ticket.order">
                            <a :href="route('admin.itemmall.orders.show', ticket.order.id)" v-html="ticket.order.id"></a>
                            <span class="fs--2 text-nowrap">(@{{ ticket.order.created_at }})</span>
                        </p>
                        <p v-else>
                            -
                        </p>
                    </div>
                    <div class="col">
                        <h5 class="fs-0">Assigned User</h5>
                        <div class="media align-items-center" v-if="ticket.assigned_user">
                            <template v-if="ticket.assigned_user.gravatar">
                                <img class="d-flex align-self-center mr-2" :src="ticket.assigned_user.gravatar" :alt="ticket.assigned_user.StrUserID" width="30">
                            </template>
                            <div class="media-body">
                                <h6 class="mb-0" v-text="ticket.assigned_user.StrUserID"></h6>
                                <small class="text-muted font-italic" v-if="ticket.assigned_user.Name" v-text="ticket.assigned_user.Name"></small>
                            </div>
                        </div>
                        <div v-else>
                            -
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Ticket Options</h5>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="new_status">Update Status</label>
                            <br />
                            <div class="btn-group d-flex align-items-stretch" id="new_status" role="group">
                                <button class="btn" type="button" v-for="(status, key) in available_statuses" v-bind:class="status.adminclass" v-text="status.name" @click="updateStatus(key)"></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="new_priority">Update Priority</label>
                            <br />
                            <div class="btn-group d-flex align-items-stretch" id="new_priority" role="group">
                                <button class="btn" type="button" v-for="(priority, key) in available_priorities" v-bind:class="priority.adminclass" v-text="priority.name" @click="updatePriority(key)"></button>
                            </div>
                        </div>
                        <hr class="my-2"/>
                        <div class="form-group d-flex justify-content-between align-content-center">
                            <div>
                                <label for="user_select">Change Assigned User</label>
                                <select id="user_select" v-model="assigned_user_form.user_id">
                                    <option></option>
                                </select>
                            </div>
                            <button class="btn btn-falcon-primary" @click="updateAssignedUser">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
{!! Theme::css('lib/fancybox/jquery.fancybox.min.css') !!}
@endsection

@section('js')
{!! Theme::js('lib/fancybox/jquery.fancybox.min.js') !!}
{!! Theme::js('lib/select2/select2.min.js') !!}
{!! Theme::js('lib/tinymce/tinymce.min.js') !!}

<script src="{{ asset('vendor/vue/components/tinymce.js') }}"></script>
<script>
    $(document).ready( function () {
        $('#user_select').select2({
            placeholder: 'Search for User to Assign',
            minimumInputLength: 2,
            allowClear: true,
            dropdownAutoWidth: true,
            ajax: {
                url: route('admin.ajax.users.get_usernames'),
                dataType: 'json',
                delay: 350,
                cache: true,
                data: function(params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function (response, params) {
                    return {
                        results: response.data,
                        pagination: {
                            more: ((params.page || 1) < response.last_page)
                        }
                    };
              },
            }
        }).on('select2:select select2:unselect', function (e) {
            this.dispatchEvent(new Event('change'))
        });
    });
</script>
<script>
    Vue.component('message-group', {
        props: ['messages'],
        template: `
        <div>
            <div class="text-center fs--2 text-500 mt-2"><span v-text="$vnode.key"></span></div>
            <message v-for="message in messages" :key="message.id" :message="message"></message>
        </div>`
    });

    Vue.component('message', {
        props: ['message'],
        data() {
            return {

            }
        },
        template: `<div class="media p-3">
        <template v-if="$root.ticket.user.JID == message.user.JID">
            <div class="avatar avatar-l mr-2" v-if="message.user.gravatar">
                <img class="rounded-circle" v-bind:src="message.user.gravatar" alt="" />
            </div>
            <div class="media-body">
                <div class="w-xxl-75">
                    <div class="hover-actions-trigger d-flex align-items-center">
                        <div class="chat-message bg-200 p-2 rounded-soft" :class="{ 'chat-gallery' : message.attachments}">
                            <template v-if="message.html">
                                <span v-html="message.content"></span>
                            </template>
                            <template v-else>
                                <span v-text="message.content"></span>
                            </template>
                            <div class="row mx-n1" v-if="message.attachments">
                                <div class="col-6 col-md-4 px-1" style="min-width: 50px; max-width: 150px;" v-for="attachment in message.attachments">
                                    <a :href="attachment.file_url" v-bind:data-fancybox="message.id">
                                        <img :src="attachment.file_url" alt="" class="img-fluid rounded mb-2">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <ul class="hover-actions position-relative list-inline mb-0 text-400 ml-2">
                            <li class="list-inline-item"><a href="#!" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fas fa-edit"></span></a></li>
                            <li class="list-inline-item"><a href="#!" data-toggle="tooltip" data-placement="top" title="Remove"><span class="fas fa-trash-alt"></span></a></li>
                        </ul>
                    </div>
                    <div class="text-400 fs--2">
                        <span v-text="message.created_at"></span>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="media-body d-flex justify-content-end">
                <div class="w-100 w-xxl-75">
                    <div class="hover-actions-trigger d-flex align-items-center justify-content-end">
                        <ul class="hover-actions position-relative list-inline mb-0 text-400 mr-2">
                            <li class="list-inline-item"><a href="#!" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fas fa-edit"></span></a></li>
                            <li class="list-inline-item"><a href="#!" data-toggle="tooltip" data-placement="top" title="Remove"><span class="fas fa-trash-alt"></span></a></li>
                        </ul>
                        <div class="bg-primary text-white p-2 rounded-soft chat-message" :class="{ 'chat-gallery' : message.attachments}">
                            <p class="mb-0">
                                <template v-if="message.html">
                                    <span v-html="message.content"></span>
                                </template>
                                <template v-else>
                                    <span v-text="message.content"></span>
                                </template>
                            </p>
                            <div class="row mx-n1" v-if="message.attachments">
                                <div class="col-6 col-md-4 px-1" style="min-width: 50px; max-width: 150px;" v-for="attachment in message.attachments">
                                    <a :href="attachment.file_url" v-bind:data-fancybox="message.id">
                                        <img :src="attachment.file_url" alt="" class="img-fluid rounded mb-2">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="avatar avatar-l ml-2" v-if="message.user.gravatar">
                            <img class="rounded-circle" v-bind:src="message.user.gravatar" alt="" />
                        </div>
                    </div>
                    <div class="text-400 fs--2 text-right">
                        <span v-text="message.created_at"></span> - <a class="text-decoration-none" :href="route('admin.users.show', message.user.JID)">@{{ message.user.StrUserID }} <template v-if="message.user.Name">(@{{ message.user.Name }})</template></a>
                    </div>
                </div>
            </div>
        </template>
    </div>`
    });

    new Vue({
        el: '#ticket_info',
        data: {
            ticket: [],
            ticket_messages: [],
            available_statuses: [],
            available_priorities: [],
            status_form: [],
            priority_form: [],
            assigned_user_form: [],
            reply_form: {
                message: '',
                attachments: []
            },
            editorConfig: {
                skin: 'oxide-dark',
                content_style: '.mce-content-body {color: #fff}',
                plugins: 'link,image,lists,table,media,autoresize',
                toolbar: 'styleselect | bold italic link bullist numlist image blockquote table media undo redo',
                statusbar: false,
                mobile: {
                    menubar: true,
                    toolbar_mode: 'floating'
                },
                menubar: true,
                menu: {
                    file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
                    edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                    view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
                    insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                    format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
                    tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
                    table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
                    help: { title: 'Help', items: 'help' }
                }
            }
        },
        components: {
            editor: Editor
        },
        created() {
            this.ticket = @json($ticket);
            this.ticket_messages = @json($ticket->messages);
            this.available_statuses = @json(config('constants.ticket_system.status'));
            this.available_priorities = @json(config('constants.ticket_system.priority'));

            this.status_form = new Form({
                status: this.ticket.status
            });

            this.priority_form = new Form({
                priority: this.ticket.priority
            });

            this.assigned_user_form = new Form({
                user_id: this.ticket.assigned_user_id
            });
        },
        computed: {
            grouped_ticket_messages: function () {
                return _.groupBy(this.ticket_messages, 'group_date')
            }
        },
        methods: {
            handleReplyAttachments: function() {
                this.reply_form.attachments = event.target.files;
                event.target.previousElementSibling.innerHTML = 'Selected file(s): ' + Array.from(event.target.files).map(x => x.name).join(', ');
            },
            submitReplyForm: function() {
                $(".content").block();

                let data = new FormData();
                data.append('message', this.reply_form.message);
                _.each(this.reply_form.attachments, (value, key) => {
                    data.append('attachments[]', value);
                });

                axios.post(event.target.action, data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    this.ticket_messages.push(response.data.new_message);

                    this.reply_form = {
                        message: '',
                        attachments: []
                    };
                })
                .catch(error => {
                    console.log('error');
                    console.log(error);
                })
                .finally(() => {
                    $(".content").unblock();
                });
            },
            updateStatus: function(status) {
                this.status_form.status = status;
                this.status_form.patch(route('admin.tickets.update_status', this.ticket.id).url())
                .then(response => {
                    this.ticket.status = this.status_form.status;
                });
            },
            updatePriority: function(priority) {
                this.priority_form.priority = priority;
                this.priority_form.patch(route('admin.tickets.update_priority', this.ticket.id).url())
                .then(response => {
                    this.ticket.priority = this.priority_form.priority;
                });
            },
            updateAssignedUser: function() {
                this.assigned_user_form.patch(route('admin.tickets.update_assigned_user', this.ticket.id).url())
                .then(response => {
                    console.log(response);
                    this.ticket.assigned_user_id = response.assigned_user.JID;
                    this.ticket.assigned_user = response.assigned_user;
                });
            }
        },
    });
</script>
@endsection
