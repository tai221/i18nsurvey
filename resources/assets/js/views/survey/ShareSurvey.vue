<template>
    <div>
        <div class="top-menu menuLight">
            <div class="menuContainer">
                <ul class="menu">
                    <router-link :to="{name: 'WelcomePage'}">
                        <li>Questions</li>
                    </router-link>
                    <li class="active">Share</li>
                    <li>Response</li>
                    <li>Analytic</li>
                    <li>Preview</li>
                </ul>
            </div>
        </div>
        <div>
            <div class="row pick-date">
                <div class="col-sm-6">
                    <span class="demonstration">Start date:</span>
                    <el-date-picker
                            v-model="start_date"
                            type="date"
                            placeholder="Pick start date">
                    </el-date-picker>
                </div>
                <div class="col-sm-6">
                    <span class="demonstration">End date:</span>
                    <el-date-picker
                            v-model="expire"
                            type="date"
                            placeholder="Pick expire date">
                    </el-date-picker>
                </div>
            </div>
            <div class="row how-would" >
                <h2>How would you like to collect responses?</h2>
            </div>
            <div class="row select-type">
                <div class="col-sm-2 col-sm-offset-3">
                    <el-radio v-model="public" label="1" border>Public</el-radio>
                </div>
                <div class="col-sm-7">
                    <el-radio v-model="public" label="0" border>Private</el-radio>
                </div>
            </div>
            <div class="row">
                <div v-if="public == 1">
                    <div style="margin-left: 370px; margin-top: 50px; color: #5fad6d;">
                        <h4>Copy this link to your respondents:</h4>
                    </div>
                    <div class="col-sm-5 col-sm-offset-7">
                        <el-input v-model="linkShare" readonly="true" >{{linkShare}}
                            <el-button v-clipboard:copy="linkShare" slot="append" icon="el-icon-document-copy" title="Coppy"></el-button></el-input>
                    </div>
                </div>
                <div v-if="public == 0" class="select-email">
                    <el-button type="success" size="medium" round>Select emails to send link</el-button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ShareSurvey",
        data() {
            return {
                start_date: '',
                expire: '',
                public: null,
                linkShare: 'http:locahost/survey/1e3c4',
            }
        }
    }
</script>

<style scoped>
    .select-email {
        padding-top: 50px;
        padding-left: 406px;
    }
    .select-type {
        padding-left: 135px;
    }
    .how-would {
        padding-left: 250px;
        padding-top: 30px;
        color: #4c737e;
    }
    .pick-date {
        padding-top: 20px;
        padding-left: 135px;
    }
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
        text-align: center;
        background: #fff;
        -webkit-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        -moz-box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
        box-shadow: 0 0 11px 0 rgba(22,45,61,.5);
    }
</style>