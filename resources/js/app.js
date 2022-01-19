import Vue from 'vue';
import router from './router';
import vPagination from 'laravel-vue-pagination';
import App from "./components/App";

require('./bootstrap');

Vue.component('pagination', vPagination);

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
});
