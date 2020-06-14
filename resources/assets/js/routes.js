import Vue from 'vue'
import Router from 'vue-router'
import Login from "./views/login/Login"
import Signup from "./views/signup/Signup";
import Layout from "./components/Layout";
import ListParticipant from "./views/table/listParticipants"
import CreateSurvey from "./views/survey/CreateSurvey"
import ManageSurvey from "./views/survey/ManageSurvey";
import WelcomePage from "./views/survey/WelcomePage";
import PageQuestion from "./views/survey/PageQuestion";
import ListSurvey from "./views/survey/ListSurvey";
import PageThanks from "./views/survey/PageThanks";
import EndPage from "./views/survey/EndPage";
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
                path: 'manage',
                component: ManageSurvey,
                children: [
                    {
                        path: '',
                        component: ListSurvey,
                        name: 'ListSurvey',
                    },
                    {
                        path: 'create',
                        component: CreateSurvey,
                        children: [
                            {
                                path:'',
                                component: WelcomePage,
                                name: 'WelcomePage',
                            },
                            {
                                path:'page-question/:pageNumber',
                                component: PageQuestion,
                                name: 'PageQuestion',
                            },
                            {
                                path: 'thanks',
                                component: EndPage,
                                name: 'ThanksPage',
                            },
                        ]
                    },

                ]

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
