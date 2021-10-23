require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import { routes } from './routes';

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter)

export const router = new VueRouter({
    base: '/',
    mode: 'history',
    routes
});

Vue.component('app', require('./vue/app.vue').default);

const app = new Vue({
    router
}).$mount('#app')