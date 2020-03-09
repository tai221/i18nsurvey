import Vue from 'vue'
import Router from 'vue-router'
import ExampleComponent from "./components/ExampleComponent";
import Login from "./views/login/Login"

Vue.use(Router)

export const routes = [
    {
        path: '/admin',
        component: ExampleComponent,
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    }


]

export default new Router({
    mode: 'history',
    routes
})
