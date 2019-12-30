import axios from 'axios';
import './bootstrap';
import Vue from 'vue';
import VueAuth from '@websanova/vue-auth';
import Vuelidate from 'vuelidate';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import Index from './Index';
import auth from './auth';
import router from './router';
import Vuex from 'vuex';
import store from './store';
import i18n from './i18n'
import BootstrapVue from 'bootstrap-vue'
import VueInputMask from 'vue-inputmask-ng'
import VueInstant from 'vue-instant'
import 'vue-instant/dist/vue-instant.css'
// import VueSocialauth from 'vue-social-auth'
import Suggestions from 'v-suggestions'
import 'v-suggestions/dist/v-suggestions.css' // you can import the stylesheets also (optional)
import VModal from 'vue-js-modal'
import vSelect from 'vue-select'

Vue.component('v-select', vSelect);
Vue.use(VModal);
Vue.component('suggestions', Suggestions);

// Set Vue globally
window.Vue = Vue;

window.moment = require('moment');
Vue.use(Vuex);
Vue.use(Vuelidate);
Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
const tmpURL = 'https://d:d@dooditask.com';
axios.defaults.baseURL = tmpURL + '/api';
axios.defaults.baseURL = '/api';

Vue.use(VueAuth, auth);

Vue.use(VueInputMask);
Vue.use(VueInstant);


// Load Index
Vue.component('index', Index);

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    BootstrapVue
});
