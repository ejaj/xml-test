require('./bootstrap');

window.Vue = require('vue');

import App from './components/App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueAxios, axios);


const app = new Vue({
    el: '#app',
    render: h => h(App),
});