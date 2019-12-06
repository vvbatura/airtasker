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
// import VueSocialauth from 'vue-social-auth'

// Set Vue globally
window.Vue = Vue;

window.moment = require('moment');
Vue.use(Vuex);
Vue.use(Vuelidate);
Vue.router = router;
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
axios.defaults.baseURL = '/api';

Vue.use(VueAuth, auth);

// Load Index
Vue.component('index', Index);

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    BootstrapVue
});
