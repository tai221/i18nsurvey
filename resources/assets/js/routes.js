import Vue from 'vue'
import Router from 'vue-router'
import Login from "./views/login/Login"
import Signup from "./views/signup/Signup";
import Layout from "./components/Layout";

Vue.use(Router)

export const routes = [
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/signup',
        component: Signup,
        name: 'signup'
    },
    {
        path: '/mypage',
        component: Layout,
        name: 'mypage'
    },



]

export default new Router({
    mode: 'history',
    routes
})
