import Vue from "vue";
import axios from "axios";
import _ from "lodash";
import swal from "sweetalert2";
import is from "is_js";
import $ from "jquery";

import Form from './core/Form';

window._ = _;
window.axios = axios;
window.Vue = Vue;
window.swal = swal;
window.is = is;
window.$ = window.jQuery = $;
window.Form = Form;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";


