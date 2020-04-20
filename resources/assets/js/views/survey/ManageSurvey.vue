<template>
    <div class="app-content">
        <div class="top-menu menuLight">
            <div class="menuContainer">
                <ul class="menu">
                    <li class="active">Questions</li>
                    <li>Share</li>
                    <li>Response</li>
                    <li>Analytic</li>
                    <li>Preview</li>
                </ul>
            </div>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "ManageSurvey"
    }
</script>

<style scoped>
    .top-menu.menuLight .menuContainer ul.menu li {
        height: 36px;
        /*font-weight: 400;*/
        /*font-family: Helvetica Neue LT W02_55 Roman,sans-serif;*/
        /*letter-spacing: .2px;*/
        font-size: 16px;
        display: block;
        /*text-decoration: none;*/
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
        /*position: absolute;*/
        /*top: 0;*/
        text-align: center;
        /*left: 0;*/
        /*z-index: 5000;*/
        background: #fff;
        -webkit-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        -moz-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
    }
    .app-content {
        /*display: block;*/
        /*position: absolute;*/
        /*top: 0;*/
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        transition: filter .5s linear;
        -webkit-transition: -webkit-filter .5s linear;
        -moz-transition: .5s -moz-filter linear;
        -ms-transition: .5s -ms-filter linear;
        -o-transition: .5s -o-filter linear;
    }
</style>