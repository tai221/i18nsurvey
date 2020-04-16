
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import App from './App'
import VueRouter from 'vue-router'
import Cookies from 'js-cookie'
import router from './routes'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import {store} from './store/store';
import './styles/index.scss' //global css
import i18n from './lang'
import * as filters from './filters' // global filters


require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(VueRouter);
Vue.use(ElementUI, {
    size: Cookies.get('size') || 'small',
    i18n: (key, value) => i18n.t(key, value)
})
Object.keys(filters).forEach(key => {
    Vue.filter(key, filters[key])
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    render: (h) => h(App)
});
