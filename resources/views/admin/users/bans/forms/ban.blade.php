<div class="form-group">
    <label>Reason <small class="text-muted">(Optional)</small></label>
    <input class="form-control" v-model="form.reason" />
</div>
<div class="form-group">
    <label>Ban Type</label>
    <div class="custom-control custom-radio">
        <input id="type_login" class="custom-control-input" type="radio" v-model="form.type" value="1">
        <label for="type_login" class="custom-control-label">Login</label>
        <small class="text-muted text-monospace" v-if="active_login_blocks">
            <template v-for="block in active_login_blocks">
                <template v-if="block.id != id && form.type != block.Type">
                    User has an active <span v-text="punishment_type[block.Type].text"></span> Block until <strong>@{{ block.timeEnd | formatDate }}</strong> | <strong>If selected, this will be overridden!</strong>
                </template>
                <template v-else-if="block.id != id && form.type == block.Type">
                    An active block will be overridden!
                </template>
                <template v-else>

                </template>
            </template>
        </small>
    </div>
    <div class="custom-control custom-radio">
        <input id="type_logininspection" class="custom-control-input" type="radio" v-model="form.type" value="2">
        <label for="type_logininspection" class="custom-control-label">Login (Inspection)</label>
        <small class="text-muted text-monospace" v-if="active_login_ins_blocks">
            <template v-for="block in active_login_ins_blocks">
                <template v-if="block.id != id && form.type != block.Type">
                    User has an active <span v-text="punishment_type[block.Type].text"></span> Block until <strong>@{{ block.timeEnd | formatDate }}</strong> | <strong>If selected, this will be overridden!</strong>
                </template>
                <template v-else-if="block.id != id && form.type == block.Type">
                    An active block will be overridden!
                </template>
                <template v-else>

                </template>
            </template>
        </small>
    </div>
    <div class="custom-control custom-radio">
        <input id="type_p2ptrade" class="custom-control-input" type="radio" v-model="form.type" value="3">
        <label for="type_p2ptrade" class="custom-control-label">P2P Trade</label>
        <small class="text-muted text-monospace" v-if="active_p2p_trade_blocks">
            <template v-for="block in active_p2p_trade_blocks">
                <template v-if="block.id != id && form.type != block.Type">
                    User has an active <span v-text="punishment_type[block.Type].text"></span> Block until <strong>@{{ block.timeEnd | formatDate }}</strong> | <strong>If selected, this will be overridden!</strong>
                </template>
                <template v-else-if="block.id != id && form.type == block.Type">
                    An active block will be overridden!
                </template>
                <template v-else>

                </template>
            </template>
        </small>
    </div>
    <div class="custom-control custom-radio">
        <input id="type_chat" class="custom-control-input" type="radio" v-model="form.type" value="4">
        <label for="type_chat" class="custom-control-label">Chat</label>
        <small class="text-muted text-monospace" v-if="active_chat_blocks">
            <template v-for="block in active_chat_blocks">
                <template v-if="block.id != id && form.type != block.Type">
                    User has an active <span v-text="punishment_type[block.Type].text"></span> Block until <strong>@{{ block.timeEnd | formatDate }}</strong> | <strong>If selected, this will be overridden!</strong>
                </template>
                <template v-else-if="block.id != id && form.type == block.Type">
                    An active block will be overridden!
                </template>
                <template v-else>

                </template>
            </template>
        </small>
    </div>
</div>
<div class="form-group">
    <label for="timeBegin">Ban Start</label>
    <input class="form-control flatpickr" type="datetime" id="timeBegin" v-model="form.timeBegin">
</div>
<div class="form-group">
    <label for="timeEnd">Ban End</label>
    <input class="form-control flatpickr" type="datetime" id="timeEnd" v-model="form.timeEnd">
</div>
