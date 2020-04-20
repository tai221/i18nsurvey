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
                        <div class="pageThumb pageThumbWelcome pageThumbActive">
                            <div class="interActive"></div>
<!--                            <i class="page-icon flaticon-welcome-v2"></i>-->
                            <i class="page-icon fa fa-sign-in"  aria-hidden="true"></i>
                        </div>
                        <div class="pageThumb">
                            <div class="interActive"></div>
<!--                            <i class="page-icon flaticon-page"></i>-->
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            <div class="number">1</div>
                        </div>
                        <div class="pageThumb pageThumbEmpty">
                            <div class="interActive"></div>
<!--                            <div class="page-icon flaticon-page-empty"></div>-->
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            <div class="number">2</div>
                        </div>
                        <div class="pageThumb pageThumbAdd">
                            <div class="interActive"></div>
<!--                            <i class="page-icon flaticon-page-add"></i>-->
                            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                        </div>
                        <div class="pageThumb pageThumbThanks">
                            <div class="interActive"></div>
<!--                            <i class="page-icon flaticon-thank-you-v2"></i>-->
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                        </div>
                        <iframe src="/_common/v2/designer/img/ui-scroll-placeholder.jpg" class="ui-scroll-iframe" data-reactid=".0.1.1.0.0.0.1.1"></iframe>
                    </div>
                </div>
            </div>
        </div>
<!--        <router-view></router-view>-->
        <WelcomePage></WelcomePage>
    </div>
</template>

<script>
    import WelcomePage from "./WelcomePage";
    export default {
        name: "CreateSurvey",
        components: {
            WelcomePage: WelcomePage,
        }
    }
</script>

<style scoped>
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
        cursor: default;
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
        top: 48px;
        height: calc(100% - 48px);
        left: 0;
        padding: 0 10px 0 4px;
        overflow: visible;
        text-align: right;
        z-index: 200;
        width: 105px;
        -webkit-transition: height .15s ease-in-out;
        -moz-transition: height .15s ease-in-out;
        -o-transition: height .15s ease-in-out;
        transition: height .15s ease-in-out;
    }
    .mainPage {
        /*position: absolute;*/
        /*top: 0;*/
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        visibility: visible;
        /*padding-top: 48px;*/
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