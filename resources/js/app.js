import Vue from "vue";
import axios from "axios";
import _ from "lodash/core";
import swal from "sweetalert2";
import is from "is_js";
import jQuery from "jquery/dist/jquery.slim";
import dayjs from "dayjs";
import Form from "./core/Form";

window._ = _;
window.axios = axios;
window.Vue = Vue;
window.swal = swal;
window.is = is;
window.dayjs = dayjs;
window.$ = window.jQuery = jQuery;
window.Form = Form;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.Vue.filter('formatDate', function(value, format) {
    if (value) {
        return dayjs(String(value)).format(format || 'DD MMMM YY hh:mm:ss');
    }
});
