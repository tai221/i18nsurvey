<template>
    <div>
        <div class="top-menu menuLight">
            <div class="menuContainer">
                <ul class="menu">
                    <router-link :to="{name: 'WelcomePage'}">
                        <li>Questions</li>
                    </router-link>
                    <li class="active">Share</li>
                    <router-link :to="{name: 'ResponseSurvey'}">
                        <li>Response</li>
                    </router-link>
                    <router-link :to="{name:'AnalyticSurvey'}">
                        <li>Analytic</li>
                    </router-link>
                    <a @click="preview()" href=""><li>Preview</li></a>
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
                            <el-button v-clipboard:copy="linkShare" @click="coppyLink()" slot="append" icon="el-icon-document-copy" title="Coppy"></el-button></el-input>
                    </div>
                </div>
                <div v-if="public == 0" class="select-email">
                    <el-button type="success" size="medium" @click="dialogTableVisible = true" round>Select emails to send link</el-button>
                </div>

            </div>
        </div>


        <el-dialog title="List participant" :visible.sync="dialogTableVisible">
            <el-table
                    ref="multipleTable"
                    :data="tableData"
                    style="width: 100%"
                    max-height="300"
                    @selection-change="handleSelectionChange">
                <el-table-column
                        type="selection"
                        width="55">
                </el-table-column>
                <el-table-column
                        label="Code"
                        width="120">
                    <template slot-scope="scope">{{ scope.row.code }}</template>
                </el-table-column>
                <el-table-column
                        property="email"
                        label="Email"
                        width="200">
                </el-table-column>
                <el-table-column
                        label="Is send?">
                        <template slot-scope="scope">
                            <span v-if="scope.row.is_send" style="color: #00ff00">Yes</span>
                            <span v-else style="color: #ff3300">No</span>
                        </template>
                </el-table-column>
                <el-table-column
                        label="Is submit?">
                    <template slot-scope="scope">
                        <span v-if="scope.row.is_submit" style="color: #00ff00">Yes</span>
                        <span v-else style="color: #ff3300">No</span>
                    </template>
                </el-table-column>
            </el-table>
            <div style="margin-top: 20px">
                <el-button @click="toggleSelection()">Clear selection</el-button>
                <el-button @click="sendMail()" type="success">Send mail</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
    import {fetchList} from "../../api/participant";
    import {shareSurvey} from "../../api/survey";
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: "ShareSurvey",
        data() {
            return {
                start_date: '',
                expire: '',
                public: null,
                linkShare: '',
                dialogTableVisible: false,
                tableData: [],
                multipleSelection: [],
            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ])
        },
        created() {
            this.linkShare = `http://127.0.0.1:8000/survey/${this.surveyId}`
            this.getListEmail()
        },
        methods: {
            toggleSelection(rows) {
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                } else {
                    this.$refs.multipleTable.clearSelection();
                }
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            },
            sendMail(){
                const data = {
                    surveyId: this.surveyId,
                    listEmail: this.multipleSelection.map(value => {
                        return value.email
                    }),
                    listIdEmail: this.multipleSelection.map(value => {
                        return value.id
                    }),
                }
                shareSurvey(data)
                    .then(res =>{
                        this.getListEmail()
                        this.$notify({
                            title: 'Notification',
                            message: 'Mails have been send',
                            type: 'success',
                            duration: 2000
                        })
                    })
                    .catch(err => {
                        this.$notify({
                            title: 'Notification',
                            message: 'Fail to send',
                            type: 'warning',
                            duration: 2000
                        })
                    })

            },
            getListEmail() {
                const data = {
                    onlyActive: true,
                    surveyId: this.surveyId,
                }
                fetchList(data)
                    .then(res => {
                        this.tableData = res.data.items
                        console.log(this.tableData)
                    })
            },
            coppyLink() {
                this.$notify({
                    title: 'Notification',
                    message: 'Link have been coppy',
                    type: 'success',
                    duration: 2000
                })
            },
            preview() {
                var win = window.open(`http://127.0.0.1:8000/survey/i18nsurvey/${this.surveyId}`, '_blank');
                win.focus();
            }
        }
    }
</script>

<style scoped>
    a {
        color: blue;
        text-decoration: none; /* no underline */
        z-index: 1000;
    }
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