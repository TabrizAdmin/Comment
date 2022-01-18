import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter)

import Post from './views/Post'

export default new VueRouter({
    routes: [
        {path: '/', name: 'post', component: Post},
    ],
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior: () => ({ y: 0 }),
});