import Vue from 'vue'
import Router from 'vue-router'
import Login from "./views/login/Login"
import Signup from "./views/signup/Signup";
import Layout from "./components/Layout";
import ListParticipant from "./views/table/listParticipants"
import CreateSurvey from "./views/survey/CreateSurvey"

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
        name: 'mypage',
        children: [
            {
                path: 'list-participant',
                component: ListParticipant,
                name: 'ListParticipant'
            },
            {
                path: 'create/survey',
                component: CreateSurvey,
                name: 'CreateSurvey'
            },
            // {
            //     path: 'manage-account',
            //     component: ManageAccount,
            //     name: 'manageaccount'
            // },
            // {
            //     path: 'manage-account/create',
            //     component: CreateAccount,
            //     name: 'createaccount',
            //     meta: {
            //         requiresAuth: true
            //     }
            // },
            // {
            //     path: 'manage-account/edit/:id',
            //     component: CreateAccount,
            //     name: 'editaccount'
            // },
            // {
            //     path: 'manage-account/result',
            //     component: ResultSearch,
            //     name: 'resultSearch'
            // }
        ]
    },



]

export default new Router({
    mode: 'history',
    routes
})
