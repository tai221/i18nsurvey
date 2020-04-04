
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from './App'
import VueRouter from 'vue-router'
import router from './routes'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import {store} from './store/store'

require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(VueRouter);
window.Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router,
    store,
    render: (h) => h(App)
});
