<template>
    <div class="mainPage mainPageBuilder mainPageActive">
        <div class="pageThumbs">
            <div class="ui-scroll-container">
                <div class="ui-scroll ui-scroll-left-side" style="max-height:624px;">
                    <div class="ui-scrollbar" style="height: 624px; opacity: 1; display: block;">
                        <div class="ui-scrollbar-track" style="height: 543px; top: 0px;">
                        </div>
                        <div></div>
                    </div>
                    <div class="ui-scroll-in" style="width: 91px;">
                        <div class="pageThumb pageThumbWelcome "
                             @click="triggerWelcome"
                             v-bind:class="{'pageThumbActive':pageThumbWelcome}">
                            <router-link :to="{name: 'WelcomePage'}">
                                <div class="interActive"></div>
                                <i class="page-icon fa fa-sign-in"  aria-hidden="true"></i>
                            </router-link>
                        </div>
                        <div v-for="page in pages"
                             class="pageThumb"
                             @click="triggerPage(page.number)"
                             v-bind:class="{'pageThumbActive':page.active, 'pageThumbEmpty':page.empty}">
                            <router-link :to="{name: 'PageQuestion', params: {pageNumber: page.number}}">
                                <div class="interActive"></div>
                                <i v-bind:class="{'fa fa-file-text-o':!page.empty, 'fa fa-file-o':page.empty}" aria-hidden="true"></i>
                                <div class="number">{{page.number}}</div>
                            </router-link>
                        </div>
                        <div class="pageThumb pageThumbAdd" @click="addPage">
                            <div class="interActive"></div>
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                        </div>
                        <div class="pageThumb pageThumbThanks"
                             @click="triggerThanks"
                             v-bind:class="{'pageThumbActive':pageThumbThanks}">
                            <router-link :to="{name: 'ThanksPage'}">
                                <div class="interActive"></div>
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                            </router-link>
                        </div>
                        <iframe src="/_common/v2/designer/img/ui-scroll-placeholder.jpg" class="ui-scroll-iframe" data-reactid=".0.1.1.0.0.0.1.1"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import {create} from "../../api/survey";
    import WelcomePage from "./WelcomePage";
    import {countPage} from "../../api/survey";

    export default {
        name: "CreateSurvey",
        data(){
            return {
                pageThumbWelcome: false,
                pageThumbThanks: false,
                pages: [
                    // {
                    //     number: 1,
                    //     empty: false,
                    //     active: false
                    // },
                    // {
                    //     number: 2,
                    //     empty: false,
                    //     active: false
                    // },
                    // {
                    //     number: 3,
                    //     empty: true,
                    //     active: false
                    // }
                ]
            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ])
        },
        created() {
            if(!this.surveyId) {
                create().then(response => {
                   let survey_id = response.data.survey_id
                    this.$store.dispatch('setSuveyId', survey_id)
                })
                this.addPage()
            } else {
                countPage(this.surveyId).then(resp => {
                     let countPage = resp.data.countPage[0].page
                     for(let i = 1; i<= countPage; i++) {
                         let page = {number: i, empty: false, active: false}
                         this.pages.push(page)
                     }
                })
            }
        },
        beforeUpdate(){
            if(this.$route.params.pageNumber) {
                this.triggerPage(this.$route.params.pageNumber)
            }
        },
        methods: {
            addPage() {
              let lastPage = this.pages.length
              let newPage = {number: lastPage+1, empty: true, active: false}
              this.pages.push(newPage)
            },
            triggerWelcome() {
                this.pages.filter(function (page) {
                    page.active = false
                })
                this.pageThumbThanks = false
                this.pageThumbWelcome = true
            },
            triggerThanks() {
                this.pages.filter(function (page) {
                    page.active = false
                })
                this.pageThumbWelcome = false
                this.pageThumbThanks = true
            },
            triggerPage(number) {
                this.pageThumbWelcome = false
                this.pageThumbThanks = false
                this.pages.filter(function (page) {
                    page.active = false
                })
                this.pages[number-1].active = true
            }
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .9s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    a:hover {
        color: white;
    }
    a {
        color: blue;
        text-decoration: none; /* no underline */
    }
    .pageThumbs .number, .ui-tutorial .number {
        position: absolute;
        top: 10px;
        left: 6px;
        font-size: 11px;
        line-height: 0;
    }
    .ui-scroll-container .ui-scroll-iframe {
        position: absolute;
        border: 0;
        background-color: transparent;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        z-index: -1;
        opacity: 0;
        filter: alpha(opacity=0);
    }
    .flaticon-thank-you-v2:before {
        content: "\F119";
    }
    pageThumbs .pageThumb.pageThumbThanks, .ui-tutorial .pageThumb.pageThumbThanks {
        margin-bottom: 0;
    }
    .flaticon-page-add:before {
        content: "\F11B";
    }
    .flaticon-page-empty:before {
        content: "\F105";
    }
    .pageThumbs .pageThumb.pageThumbEmpty .number, .pageThumbs .pageThumb.pageThumbEmpty i, .ui-tutorial .pageThumb.pageThumbEmpty .number, .ui-tutorial .pageThumb.pageThumbEmpty i {
        color: rgba(0,0,0,.4);
    }
    .pageThumbs .pageThumb .number, .pageThumbs .pageThumb i, .ui-tutorial .pageThumb .number, .ui-tutorial .pageThumb i {
        -webkit-transition: color .15s ease-in-out;
        -moz-transition: color .15s ease-in-out;
        -o-transition: color .15s ease-in-out;
        transition: color .15s ease-in-out;
    }
    .flaticon-page:before {
        content: "\F106";
    }
    [class*=" flaticon-"]:after, [class*=" flaticon-"]:before, [class^=flaticon-]:after, [class^=flaticon-]:before {
        font-family: Flaticon;
        font-style: normal;
    }
    .flaticon-welcome-v2:before {
        content: "\F11A";
    }
    i {
        font-style: normal;
    }
    .pageThumbs .pageThumb i, .ui-tutorial .pageThumb i {
        display: inline-block;
        font-size: 23px;
        line-height: 0;
        padding-top: 27px;
        position: relative;
        z-index: 10;
    }
    .pageThumbs .interActive {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 2000;
        background-color: hsla(0,0%,100%,0);
    }
    .pageThumbs .pageThumb, .ui-tutorial .pageThumb {
        display: block;
        width: 55px;
        background-color: #fff;
        height: 55px;
        border: 1px solid rgba(0,0,0,.2);
        margin: 6px 0;
        cursor: pointer;
        position: relative;
        text-align: center;
        font-weight: 400;
        font-family: Helvetica Neue LT W02_55 Roman,sans-serif;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        -webkit-transition: background-color .15s ease-in-out;
        -moz-transition: background-color .15s ease-in-out;
        -o-transition: background-color .15s ease-in-out;
        transition: background-color .15s ease-in-out;
    }
    .pageThumbs .pageThumb:first-child, .ui-tutorial .pageThumb:first-child {
        margin-top: 0;
    }
    .pageThumbs .pageThumb.pageThumbActive, .pageThumbs .pageThumb.pageThumbActive:hover, .pageThumbs .pageThumb.pageThumbEmpty.pageThumbActive, .pageThumbs .pageThumb.pageThumbEmpty.pageThumbActive:hover, .ui-tutorial .pageThumb.pageThumbActive, .ui-tutorial .pageThumb.pageThumbActive:hover, .ui-tutorial .pageThumb.pageThumbEmpty.pageThumbActive, .ui-tutorial .pageThumb.pageThumbEmpty.pageThumbActive:hover {
        /*cursor: default;*/
        background-color: #3899ec;
    }
    .pageThumbs .pageThumb.pageThumbWelcome.pageThumbActive, .pageThumbs .pageThumb.pageThumbWelcome.pageThumbActive:hover, .ui-tutorial .pageThumb.pageThumbWelcome.pageThumbActive, .ui-tutorial .pageThumb.pageThumbWelcome.pageThumbActive:hover {
        background-color: #3899ec;
    }
    .ui-scroll-container .ui-scroll-in {
        position: relative;
        display: block;
        width: 100%;
        z-index: 10;

    }
    .pageThumbs .ui-scroll-container .ui-scroll-in {
        padding-top: 26px;
        padding-bottom: 26px;
    }
    .ui-scroll-container .ui-scrollbar, .ui-scroll-container .ui-scrollbar-track {
        position: absolute;
        top: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .ui-scroll-container .ui-scrollbar-track {
        left: 0;
        width: 100%;
        height: auto;
        background-color: rgba(53,152,253,.4);
        -webkit-transition: color .15s ease-in-out;
        -moz-transition: color .15s ease-in-out;
        -o-transition: color .15s ease-in-out;
        transition: color .15s ease-in-out;
    }
    .pageThumbs .ui-scroll-container .ui-scrollbar-track {
        background-color: rgba(0,0,0,.2);
        border: 1px solid hsla(0,0%,100%,.2);
        -webkit-transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
        -moz-transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
        -ms-transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
        -o-transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
        transition: background-color .15s ease-in-out,border-color .15s ease-in-out;
    }
    .ui-scroll-container .ui-scrollbar, .ui-scroll-container .ui-scrollbar-track {
        position: absolute;
        top: 0;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
    }
    .pageThumbs .ui-scroll-container .ui-scrollbar {
        width: 6px;
    }
    .ui-scroll-container .ui-scroll.ui-scroll-left-side .ui-scrollbar {
        right: auto;
        left: 3px;
    }
    .ui-scroll-container .ui-scroll {
        display: block;
        width: calc(100% + 30px);
        overflow-x: hidden;
        overflow-y: auto;
    }
    .pageThumbs .ui-scroll-container .ui-scroll {
        padding-left: 18px;
    }
    .ui-scroll-container {
        display: block;
        width: 100%;
        overflow: hidden;
        position: relative;
    }
    .pageThumbs {
        /*position: absolute;*/
        /*top: 48px;*/
        height: calc(100% - 48px);
        /*left: 0;*/
        /*padding: 0 10px 0 4px;*/
        /*overflow: visible;*/
        /*text-align: right;*/
        /*z-index: 200;*/
        /*width: 105px;*/
        -webkit-transition: height .15s ease-in-out;
        -moz-transition: height .15s ease-in-out;
        -o-transition: height .15s ease-in-out;
        transition: height .15s ease-in-out;
        display: inline-block;
        vertical-align: top;
    }
    .mainPage {
        width: 100%;
        height: 100%;
        /*z-index: 1000;*/
        /*visibility: visible;*/
        padding-top: 48px;
        display: none;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .mainPage.mainPageActive {
        display: block;
    }
</style>