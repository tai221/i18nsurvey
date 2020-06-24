<template>
    <div>

        <div class="top-menu menuLight">
            <div class="menuContainer">
                <ul class="menu">
                    <router-link :to="{name: 'WelcomePage'}">
                        <li>Questions</li>
                    </router-link>
                    <router-link :to="{name: 'ShareSurvey'}">
                        <li>Share</li>
                    </router-link>
                    <router-link :to="{name:'ResponseSurvey'}">
                        <li>Response</li>
                    </router-link>
                    <li class="active">Analytic</li>
                    <a @click="preview()" href=""><li>Preview</li></a>
                </ul>
            </div>
        </div>

        <div v-for="(q,i) in list">
            <div class="row question">
                <div class="col-sm-5">
                    <i>Question {{i+1}}</i> :<span style="color:#31040d">{{q.question}}</span>
                </div>
                <div class="col-sm-5 offset-sm-1">
                    <apexchart type="donut"  width="350" :options="q.arrChoice" :series="q.arrCnt"></apexchart>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import VueApexCharts from 'vue-apexcharts'
    import {analytic} from "../../api/survey";

    export default {
        name: "AnalyticSurvey",
        components: {
            apexchart: VueApexCharts,
        },
        data() {
            return {
                list:[],
                // series: [44, 55, 13, 43, 22],
                // chartOptions: {
                //     // chart: {
                //     //     width: 20,
                //     //     type: 'pie',
                //     // },
                //     labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                //     // responsive: [{
                //     //     breakpoint: 10,
                //     //     options: {
                //     //         chart: {
                //     //             width: 20
                //     //         },
                //     //         legend: {
                //     //             position: 'bottom'
                //     //         }
                //     //     }
                //     // }]
                // },
            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ])
        },
        created() {
            const data = {surveyId: this.surveyId}
            analytic(data)
                .then(res => {
                    this.list = res.data.listQuestion
                    console.log(this.list)
                })
        },
        methods: {
            preview() {
                var win = window.open(`http://127.0.0.1:8000/survey/i18nsurvey/${this.surveyId}`, '_blank');
                win.focus();
            },
        }
    }
</script>

<style scoped>
    .question {
        padding-left: 10px;
        margin-top: 20px;
        background-color: #aecee2;
        margin-bottom: 20px;
        margin-right: 20px;
    }
    .top-menu.menuLight .menuContainer ul.menu li {
        height: 36px;
        font-size: 16px;
        display: block;
        color: #38586f;
        padding: 7px 15px 9px;
        -webkit-border-radius: 18px;
        -moz-border-radius: 18px;
        border-radius: 18px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .top-menu.menuLight .menuContainer ul.menu li.active  {
        background: #3899ec;
        color: #f7fafd;
    }
    .top-menu.menuLight .menuContainer ul.menu {
        display: flex;
        margin: 0;
        padding: 0;
        *zoom: 1;
    }
    .top-menu.menuLight .menuContainer {
        display: inline-block;
        width: auto;
    }
    .top-menu.menuLight {
        display: block;
        width: 100%;
        height: 48px;
        text-align: center;
        background: #fff;
        -webkit-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        -moz-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
    }
</style>