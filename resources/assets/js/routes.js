import Vue from 'vue'
import Router from 'vue-router'
import ExampleComponent from "./components/ExampleComponent";

Vue.use(Router)

export const routes = [
    {
        path: '/admin',
        component: ExampleComponent,
    }
]

export default new Router({
    mode: 'history',
    routes
})
