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
                    <li class="active">Response</li>
                    <router-link :to="{name:'AnalyticSurvey'}">
                        <li>Analytic</li>
                    </router-link>
                    <a @click="preview()" href=""><li>Preview</li></a>
                </ul>
            </div>
        </div>
        <div>
<!--            <el-table-->
<!--                    :data="listQuestion"-->
<!--                    style="width: 100%">-->
<!--                <el-table-column-->
<!--                        fixed-->
<!--                        label="Question"-->
<!--                        width="150">-->
<!--                </el-table-column>-->
<!--                <el-table-column v-for="(question, indexQuestion) in listQuestion" :key="indexQuestion"-->
<!--                        v-bind:label="question.question"-->
<!--                        width="200">-->
<!--                </el-table-column>-->
<!--            </el-table>-->
<!--            <el-table-->
<!--                    :data="listRespondent"-->
<!--                    style="width: 100%"-->
<!--                    max-height="500">-->
<!--                <el-table-column-->
<!--                        fixed-->
<!--                        prop="email_id"-->
<!--                        label="Respondent"-->
<!--                        width="150">-->
<!--                </el-table-column>-->
<!--&lt;!&ndash;                <div v-for="(question, indexQuestion) in listQuestion" :key="indexQuestion">&ndash;&gt;-->
<!--&lt;!&ndash;                    <el-table-column&ndash;&gt;-->
<!--&lt;!&ndash;                            v-bind:label="String(indexQuestion)"&ndash;&gt;-->
<!--&lt;!&ndash;                            prop="listResponse[1].answer"&ndash;&gt;-->
<!--&lt;!&ndash;                            width="120">&ndash;&gt;-->
<!--&lt;!&ndash;                    </el-table-column>&ndash;&gt;-->
<!--&lt;!&ndash;                </div>&ndash;&gt;-->
<!--                <el-table-column-->
<!--                        prop="listResponse[0].answer"-->
<!--                        label="Created"-->
<!--                        width="200">-->
<!--                </el-table-column>-->
<!--                <el-table-column-->
<!--                        prop="listResponse[1].answer"-->
<!--                        label="Created"-->
<!--                        width="200">-->
<!--                </el-table-column>-->
<!--                <el-table-column-->
<!--                        prop="listResponse[2].answer"-->
<!--                        label="Created"-->
<!--                        width="200">-->
<!--                </el-table-column>-->
<!--                <el-table-column-->
<!--                        prop="listResponse[3].answer"-->
<!--                        label="Created"-->
<!--                        width="200">-->
<!--                </el-table-column>-->
<!--                <el-table-column-->
<!--                        fixed="right"-->
<!--                        label="Submit at"-->
<!--                        prop="created_at"-->
<!--                        width="150">-->
<!--                </el-table-column>-->
<!--            </el-table>-->


<!--                         Fixed header table-->
                         <div class="button-export" v-if="isHaveResponse">
                            <el-button  class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">Export</el-button>
                        </div>
                        <div class="table-responsive" v-if="isHaveResponse">
                            <table class="table table-fixed">
                                <thead>
                                <tr>
                                    <th >Respondent</th>
                                    <th v-for="(q,i) in listQuestion" style="color: #ce8483" >{{q.question}}<span v-if="q.required==1" style="color: red">*</span></th>
                                    <th style="color:">Submited at</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(rd,i) in listRespondent">
                                    <td v-if="rd.email_id!==null">{{rd.email_id}}</td>
                                    <td v-else>{{i+1}}</td>
                                    <td v-for="(res,j) in rd.listResponse" >
                                        <div v-if="res.setup==0||res.setup==1">
                                            <span v-if="res.setup==0" v-bind:class="{dapankhac: res.setup==0}">Other: </span>
                                            {{res.answer}}
                                        </div>
                                        <div v-if="res.setup==2">
                                            <span>{{res.answer}}</span> <i v-for="i in parseInt(res.answer)" class="el-icon-star-on"></i>
                                        </div>
                                    </td>
                                    <td >{{rd.created_at}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- End -->
                        <div v-if="!isHaveResponse" style="margin: auto; width: 50%; margin-bottom:40px; text-align:center;">
                            <h2>There are no response for this survey</h2>
                            <h3></h3>
                            <el-button type="text" @click="goToShare()" size="medium">Click here to go to share</el-button>
                        </div>

        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import {getAllResponse} from "../../api/survey";
    import {export_json_to_excel} from "../../vendor/Export2Excel";

    export default {
        name: "ResponseSurvey",
        data() {
            return {
                listRespondent: [],
                listQuestion: [],
                dapankhac:'dapankhac',
                isHaveResponse: false,

            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ])
        },
        created() {
            getAllResponse(this.surveyId)
                .then(res => {
                    this.listRespondent = res.data.listRespondent
                    this.listQuestion = res.data.listQuestion
                    if(this.listRespondent.length > 0) {
                        this.isHaveResponse = true
                    }
                    console.log(res.data.listRespondent)
                    console.log(res.data.listQuestion)
                })
        },
        methods: {
            goToShare() {
                this.$router.push({ name: 'ShareSurvey'})
            },
            preview() {
                var win = window.open(`http://127.0.0.1:8000/survey/i18nsurvey/${this.surveyId}`, '_blank');
                win.focus();
            },
            handleDownload(){
                var tHeader = ['Respondent']
                for(let i = 0; i < this.listQuestion.length; i++) {
                    tHeader.push(this.listQuestion[i].question)
                }
                tHeader.push('Submited at')
                const filterVal = ['id','created_at']
                var data = []
                for(let i=0; i< this.listRespondent.length; i++) {
                    var temp = []
                    if(this.listRespondent[i].email_id!==null) {
                        temp.push(this.listRespondent[i].email_id)
                    }else {
                        temp.push(i+1)
                    }
                    for(let j=0; j < this.listRespondent[i].listResponse.length; j++) {
                        temp.push(this.listRespondent[i].listResponse[j].answer)
                    }
                    temp.push(this.listRespondent[i].created_at)
                    data.push(temp)
                }
                console.log(data)
                export_json_to_excel({
                    header: tHeader, //Header Required
                    data, //Specific data Required
                    filename: 'list-response', //Optional
                    autoWidth: true, //Optional
                    bookType: 'xlsx' //Optional
                })
            },
            formatJson(filterVal, jsonData) {
                return jsonData.map(v => filterVal.map(j => {
                        return v[j]
                }))
            }
        },
    }
</script>

<style scoped>
    .button-export {
        float: right;
        padding-top: 10px;
    }
    .dapankhac {
        color: #00BF6F;
    }
    a {
        color: blue;
        text-decoration: none; /* no underline */
        z-index: 1000;
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