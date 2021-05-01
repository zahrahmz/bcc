/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import {StatusIndicator} from 'vue-status-indicator';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Vue from 'vue';
import SuiVue from 'semantic-ui-vue';
import Select2 from 'v-select2-component';



window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'Content-Type': 'application/json',
    'Accept': 'application/json'
};
window.axios.defaults.baseURL = '/api/admin/'

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
window.Vue = require('vue');
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('order-index', require('./components/order-index.vue').default);
Vue.component('status-indicator', StatusIndicator);
Vue.component('Loading', Loading);
Vue.component('Select2', Select2);
Vue.use(require('vue-moment-jalaali'));
Vue.use(SuiVue);

const app = new Vue({
    el: '#app',
    components:{
        Loading
    }
});


