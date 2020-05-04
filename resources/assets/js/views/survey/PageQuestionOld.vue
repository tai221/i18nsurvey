<template>
    <div class="page-in">
        <div class="align">
            <div class="page-in-app">
                <span> </span>
                <div class="addContainer placeholderActive">
                    <div class="appAddQuestion">
                        <div class="appAddBarPlacehoder" style="color:#000;">
                            This page is empty. ADD A QUESTION!
                        </div>
                        <div class="appAddBarPosition">
                            <div class="appAddBarContainer">
                                <div class="appAddBar">
                                    <div class="appAddPlusPosition">
                                        <div class="appAddPlus">

                                        </div>
                                    </div>
                                </div>
                                <div class="borderLeft">

                                </div>
                                <div class="borderRight">

                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="question-bubble-container" data-index="0">-->
<!--                        <div class="question-bubble">-->
<!--                            <div class="question-bubble-border">-->
<!--                                <div class="question-bubble-in">-->
<!--                                    <div class="elements-list">-->
<!--                                        <ul>-->
<!--                                            <li class="inElement element-sc">-->
<!--                                                <i></i>-->
<!--                                                <a>Single choice</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-mc">-->
<!--                                                <i></i>-->
<!--                                                <a>Multiple choice</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-txt">-->
<!--                                                <i></i>-->
<!--                                                <a>Text answer</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-sc-img">-->
<!--                                                <i></i>-->
<!--                                                <a>Image choice</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-star">-->
<!--                                                <i></i>-->
<!--                                                <a>Rating</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-diff">-->
<!--                                                <i></i>-->
<!--                                                <a>Semantic differential</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-nps">-->
<!--                                                <i></i>-->
<!--                                                <a>Net Promoter Score</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-rating">-->
<!--                                                <i></i>-->
<!--                                                <a>Rating scale</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-order">-->
<!--                                                <i></i>-->
<!--                                                <a>Ordering</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-matrix-sc">-->
<!--                                                <i></i>-->
<!--                                                <a>Matrix - single choices</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-matrix-mc">-->
<!--                                                <i></i>-->
<!--                                                <a>Matrix - multiple choices</a>-->
<!--                                            </li>-->
<!--                                            <li class="inElement element-text">-->
<!--                                                <i></i>-->
<!--                                                <a>Add text-->
<!--                                                </a>-->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PageQuestion"
    }
</script>

<style scoped>
    .question-bubble-container {
        display: block;
        width: 100%;
        text-align: center;
        height: 0;
    }
    .addContainer .appAddBarContainer .borderRight {
        left: auto;
        right: 0;
    }
    .addContainer .appAddBarContainer .borderLeft, .addContainer .appAddBarContainer .borderRight {
        position: absolute;
        top: 50%;
        left: 0;
        width: calc(50% - 20px);
        height: 0;
        border-top: 1px dashed hsla(0,0%,100%,.3);
        border-bottom: 1px dashed rgba(0,0,0,.3);
        -webkit-transition: opacity .15s ease-in-out;
        -moz-transition: opacity .15s ease-in-out;
        -o-transition: opacity .15s ease-in-out;
        transition: opacity .15s ease-in-out;
    }
    #tutorial-portal .appAddPlus:after, .addContainer .appAddBarContainer .appAddPlus:after {
        top: 12px;
        left: 8px;
        width: 10px;
        height: 2px;
    }
    #tutorial-portal .appAddPlus:after, #tutorial-portal .appAddPlus:before, .addContainer .appAddBarContainer .appAddPlus:after, .addContainer .appAddBarContainer .appAddPlus:before {
        content: "";
        position: absolute;
        top: 8px;
        left: 12px;
        height: 10px;
        width: 2px;
        visibility: visible;
        background: rgba(0,0,0,.3);
        opacity: 1;
        filter: alpha(opacity=100);
        -webkit-transition: background .15s ease-in-out,opacity .15s ease-in-out;
        -moz-transition: background .15s ease-in-out,opacity .15s ease-in-out;
        -ms-transition: background .15s ease-in-out,opacity .15s ease-in-out;
        -o-transition: background .15s ease-in-out,opacity .15s ease-in-out;
        transition: background .15s ease-in-out,opacity .15s ease-in-out;
    }
    #tutorial-portal .appAddPlus, .addContainer .appAddBarContainer .appAddPlus {
        display: block;
        position: relative;
        width: 28px;
        cursor: pointer;
        height: 28px;
        background: hsla(0,0%,100%,.4);
        border: 1px solid rgba(0,0,0,.4);
        z-index: 100;
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        border-radius: 100%;
        -webkit-transition: background .15s ease-in-out,border-color .15s ease-in-out;
        -moz-transition: background .15s ease-in-out,border-color .15s ease-in-out;
        -ms-transition: background .15s ease-in-out,border-color .15s ease-in-out;
        -o-transition: background .15s ease-in-out,border-color .15s ease-in-out;
        transition: background .15s ease-in-out,border-color .15s ease-in-out;
    }
    #tutorial-porta .appAddPlusPosition, .addContainer .appAddBarContainer .appAddPlusPosition {
        position: absolute;
        top: -13px;
        left: 50%;
        margin-left: -14px;
        width: 28px;
        height: 28px;
    }
    .addContainer .appAddBarContainer .appAddBar {
        display: block;
        width: 100%;
        position: relative;
    }
    .addContainer .appAddBarContainer {
        position: relative;
        top: 15px;
        width: 100%;
        display: block;
    }
    .appAddQuestion .appAddBarPosition {
        position: absolute;
        top: -17px;
        left: 0;
        width: 100%;
        height: 30px;
        cursor: pointer;
        visibility: visible;
        -webkit-transition: opacity .15s ease-in-out;
        -moz-transition: opacity .15s ease-in-out;
        -o-transition: opacity .15s ease-in-out;
        transition: opacity .15s ease-in-out;
    }
    .addContainer .appAddQuestion .appAddBarPlacehoder {
        cursor: pointer;
        position: absolute;
        width: 100%;
        text-align: center;
        top: -200px;
        opacity: 1;
        transition: opacity .5s linear;
        box-sizing: border-box;
        font-size: 20px;
        padding: 125px 0 0;
        font-weight: 400;
        font-family: Helvetica Neue LT W02_41488880,sans-serif;
        background: url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zd…JjbHMtMTgiIGZpbGwtcnVsZT0iZXZlbm9kZCIvPgogICAgPC9nPgogIDwvZz4KPC9zdmc+Cg==) no-repeat top;
        background-size: 200px auto;
    }
    .appAddQuestion {
        display: inline-block;
        width: 100%;
        max-width: 640px;
        position: relative;
        z-index: 1000;
    }
    /*.addContainer {*/
    /*    -webkit-transition: padding-top .15s ease-in-out;*/
    /*    -moz-transition: padding-top .15s ease-in-out;*/
    /*    -o-transition: padding-top .15s ease-in-out;*/
    /*    transition: padding-top .15s ease-in-out;*/
    /*}*/
    /*.addContainer {*/
    /*    display: block;*/
    /*    position: relative;*/
    /*    width: 100%;*/
    /*    z-index: 100;*/
    /*}*/
    .addContainer.placeholderActive {
        padding-top: 200px;
    }
    .page-in-app {
        display: inline-block;
        width: 100%;
        height: auto;
        padding: 40px 0 90px;
    }
    /*@media only screen and (min-width: 0)*/
    /*     .page-in .align {*/
    /*        display: table-cell;*/
    /*        width: 100%;*/
    /*        height: 100%;*/
    /*        text-align: center;*/
    /*        vertical-align: middle;*/
    /*        padding: 30px 18px 91px;*/
    /*        -webkit-box-sizing: border-box;*/
    /*        -moz-box-sizing: border-box;*/
    /*        box-sizing: border-box;*/
    /*    }*/
    /*.page-in .align {*/
    /*    padding: 0;*/
    /*}*/
    /*.page-in {*/
    /*    display: table;*/
    /*    width: 100%;*/
    /*    height: 100%;*/
    /*    position: absolute;*/
    /*    top: 0;*/
    /*    left: 0;*/
    /*}*/
    .page-in .align {
        display: table-cell;
        width: 100%;
        height: 100%;
        text-align: center;
        vertical-align: middle;
        padding: 30px 18px 91px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .page-in .align {
        padding: 0;
    }
    .page-in {
        display: table;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>