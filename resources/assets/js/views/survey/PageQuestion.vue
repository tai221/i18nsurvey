<template>
    <div class="page-in" :key="pageNumber">
        <div class="align">
            <div class="page-in-app">
                <span> </span>
                <div class="addContainer placeholderActive">

                    <div v-if="questions.length == 0" class="appAddQuestion" @click="dialogVisible=true">
                        <div class="appAddBarPlacehoder" style="color:#000;">
                            This page is empty. ADD A QUESTION!
                        </div>
                        <IconPlus></IconPlus>
                    </div>
                    <div v-if="questions.length > 0" v-for="(question,index) in questions" >
                        <transition name="fade">
                            <el-button-group class="group-button" v-if="groupButtonVisible == index">
                                <el-button type="primary"
                                           @click="editQuestion(question.id, question.order_page, index)">Edit</el-button>
                                <el-button type="info" >Move</el-button>
                                <el-button type="danger"
                                           @click="deleteQuestion(question.id, index)"
                                           icon="el-icon-delete"></el-button>
                            </el-button-group>
                        </transition>
                        <div class="box-question" v-if="question.type == 1" @click="changeGroupButton(index)">
                            <div class="title-question">
                                {{index+1}}. {{question.question}}<span v-if="question.required" style="color: red">*</span>
                            </div>
                            <div class="title-answer" v-for="(answer, index) in question.answers" :class="answer.key == 100? 'other-answer':'' ">
                                {{answer.content}}
                            </div>
                        </div>
                        <div class="appAddQuestion" @click="dialogVisible=true">
<!--                            <div class="appAddBarPlacehoder" style="color:#000;">-->
<!--                                This page is empty. ADD A QUESTION!-->
<!--                            </div>-->
                            <IconPlus></IconPlus>
                        </div>
                    </div>
                    <el-dialog title="CHOOSE TYPE OF QUESTION" :visible.sync="dialogVisible" width="90%" :close-on-click-modal="true">
                    <div class="question-bubble-container" >
                        <div class="question-bubble">
                            <div class="question-bubble-border">
                                <div class="question-bubble-in">
                                    <div class="elements-list">
                                        <ul>
                                            <li class="inElement element-sc" @click="dialogVisible=false; visableSingleChoice=true">
                                                <i></i>
                                                <a>Single choice</a>
                                            </li>
                                            <li class="inElement element-mc">
                                                <i></i>
                                                <a>Multiple choice</a>
                                            </li>
                                            <li class="inElement element-txt">
                                                <i></i>
                                                <a>Text answer</a>
                                            </li>
                                            <li class="inElement element-sc-img">
                                                <i></i>
                                                <a>Image choice</a>
                                            </li>
                                            <li class="inElement element-star">
                                                <i></i>
                                                <a>Rating</a>
                                            </li>
                                            <li class="inElement element-diff">
                                                <i></i>
                                                <a>Semantic differential</a>
                                            </li>
                                            <li class="inElement element-nps">
                                                <i></i>
                                                <a>Net Promoter Score</a>
                                            </li>
                                            <li class="inElement element-rating">
                                                <i></i>
                                                <a>Rating scale</a>
                                            </li>
                                            <li class="inElement element-order">
                                                <i></i>
                                                <a>Ordering</a>
                                            </li>
                                            <li class="inElement element-matrix-sc">
                                                <i></i>
                                                <a>Matrix - single choices</a>
                                            </li>
                                            <li class="inElement element-matrix-mc">
                                                <i></i>
                                                <a>Matrix - multiple choices</a>
                                            </li>
                                            <li class="inElement element-text">
                                                <i></i>
                                                <a>Add text
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </el-dialog>
                    <SingleChoice :visableSingleChoice.sync="visableSingleChoice"
                                  :pageNumber="pageNumber"
                                  :orderPage="OrderPage"
                                  :idQuestion="idQuestion"
                                  @addQuestion="questions.push($event)"
                                  @updateQuestion="questions[indexQuestion]=$event"
                                  @SingleChoiceClose="visableSingleChoice=false"
                    ></SingleChoice>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import IconPlus from "../../components/IconPlus";
    import SingleChoice from "../../components/Question/SingleChoice";
    import { mapGetters, mapActions } from 'vuex'
    import {deleteQuestion} from "../../api/question";
    import {getListQuestions} from "../../api/question"
    export default {
        name: "PageQuestion",
        components: {
            IconPlus,
            SingleChoice,
        },
        data() {
            return {
                dialogVisible: false,
                visableSingleChoice: false,
                pageNumber: null,
                questions: [],
                groupButtonVisible: null,
                idQuestion: null,
                indexQuestion: null,
                orderPage: null,
            }
        },
        watch: {
            $route (to, from){
                this.updatePageNumber()
                this.pageNumber = this.$route.params.pageNumber
            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ]),
            OrderPage: {
                get: function () {
                    if(this.orderPage == null) {
                        return this.questions.length + 1
                    }
                    return this.orderPage
                },
                set: function (value) {
                    this.orderPage = value
                }
            }
        },
        created(){
            console.log('created pageQuestion')
            const app= this
            const {pageNumber} = app.$route.params
            this.pageNumber = pageNumber
            const data = {
                surveyId: this.surveyId,
                pageNumber: pageNumber,
            }
            getListQuestions(data)
                .then(resp => {
                    this.questions = resp.data.questions
                })
                .catch(resp => {

                })
        },
        methods: {
            // SingleChoiceClose(){
            //     this.visableSingleChoice = false
            //     console.log('questions'+ this.questions)
            // }
            editQuestion(id, order, index) {
                this.idQuestion = id
                this.visableSingleChoice = true
                this.OrderPage = order
                this.indexQuestion = index
                console.log('order'+this.OrderPage + 'id'+ this.idQuestion+ 'index'+ this.indexQuestion)
            },
            deleteQuestion(id, index) {
                const data = {idQuestion: id}
                deleteQuestion(data)
                    .then(resp => {
                        this.questions.splice(index, 1)
                        this.$notify({
                            title: 'Notification',
                            message: 'Success',
                            type: 'success',
                            duration: 2000
                        })
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            updatePageNumber(){
                const data = {
                    surveyId: this.surveyId,
                    pageNumber: this.$route.params.pageNumber,
                }
                getListQuestions(data)
                    .then(resp => {
                        this.questions = resp.data.questions
                    })
                    .catch(resp => {

                    })
            },
            changeGroupButton(index) {
                if(this.groupButtonVisible != null && this.groupButtonVisible != index) {
                    this.groupButtonVisible = null
                    this.groupButtonVisible = index
                } else if(this.groupButtonVisible != null && this.groupButtonVisible == index) {
                    this.groupButtonVisible = null
                } else {
                    this.groupButtonVisible = index
                }
            }
        }
    }
</script>

<style scoped>
    .group-button::after {
        content: '';
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 8px solid #ff4b18;
        position: absolute;
        /* bottom: 121px; */
        left: 50%;
        /* -webkit-transform: translate(-50%, -50%); */
        transform: translate(-40%, 401%);
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.9s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    .title-answer {
        height: 40px;
        border-color: #5ce885;
        border-radius: 5px;
        background-color: #19bf4b;
        text-align: left;
        margin-bottom: 5px;
        color: black;
        padding: 8px 0px 10px 10px;

    }
    .other-answer {
        color: #484848;
        display: flex;
    }
    .other-answer::after {
        content: url("../../images/input.png");
        transform: translate(378px, -5px);
    }
    .title-question {
        font-size: 24px;
        color: black;
        text-align: left;
    }
    .box-question {
        border: 0.25px solid;
        /*width: 45%;*/
        padding: 20px 10px 10px 10px;
        margin: auto;
        background-color: #ccffcc;
    }
    .box-question:hover {
        cursor: pointer;
    }
    li.element-sc i {
        background-image: url("../../images/SingleChoice.png")
    }
    a, a:hover {
        text-decoration: underline;
        transition: .3s;
        cursor: pointer;
    }
    .question-bubble .question-bubble-in .elements-list ul li a {
        padding-top: 0;
        min-height: 35px;
        font-size: 12px;
        color: #070707;
        text-decoration: none;
        line-height: 19px;
    }
    body.helvetica #app .addContainer .elements-list ul li a, body.helvetica #app .addContainer .elements-list ul li a:hover {
        font-weight: 400;
        font-family: Helvetica Neue LT W02_55 Roman,sans-serif;
        font-size: 13px;
    }
    .question-bubble .question-bubble-in .elements-list ul li i {
        height: 75px;
        margin-top: 0;
        background-position: center 17px;
        background-repeat: no-repeat;
    }

    i {
        font-style: normal;
    }
    .question-bubble .question-bubble-in .elements-list ul li a, .question-bubble .question-bubble-in .elements-list ul li i {
        display: block;
        width: 100%;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .question-bubble .question-bubble-in .elements-list ul li:first-child {
        -webkit-border-top-left-radius: 3px;
        -moz-border-radius-topleft: 3px;
        border-top-left-radius: 3px;
    }
    .question-bubble .question-bubble-in .elements-list ul li {
        float: left;
        width: 168px;
        height: 110px;
        background: #fff;
        cursor: pointer;
        overflow: hidden;
        -webkit-box-shadow: 0 0 6px 0 rgba(22,45,61,.14);
        -moz-box-shadow: 0 0 6px 0 rgba(22,45,61,.14);
        box-shadow: 0 0 6px 0 rgba(22,45,61,.14);
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    @media screen and (min-width: 516px)
    li, p {
        line-height: 150%;
    }
    li, p {
        line-height: 130%;
    }
    li {
        background: none;
        list-style: none;
    }
    .question-bubble .question-bubble-in .elements-list ul:after, .question-bubble .question-bubble-in .elements-list ul:before {
        display: table;
        content: "";
        line-height: 0;
    }
    .question-bubble .question-bubble-in .elements-list ul {
        display: block;
        width: 100%;
        margin: 0;
        padding: 0;
        *zoom: 1;
    }
    @media only screen and (min-width: 0)
    address, p, ul {
        padding: 15px 0 0;
    }
    p, ul {
        padding: 35px 0 0;
        line-height: 140%;
    }
    ol, ul {
        list-style: none;
    }
    .question-bubble .question-bubble-in .elements-list {
        display: block;
        width: 100%;
        background: #fff;
    }
    .question-bubble .question-bubble-in {
        display: block;
        width: 100%;
        padding: 25px 19px 19px;
    }
    .question-bubble {
        display: inline-block;
        background: rgba(245,249,252,.25);
        overflow: hidden;
        /*visibility: hidden;*/
        width: 1046px;
        /*height: 0;*/
        /*opacity: 0;*/
        filter: alpha(opacity=0);
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
        -webkit-box-shadow: 0 0 13px 0 rgba(22,45,61,.2);
        -moz-box-shadow: 0 0 13px 0 rgba(22,45,61,.2);
        box-shadow: 0 0 13px 0 rgba(22,45,61,.2);
        visibility: visible;
        height: 264px;
        opacity: 1;
    }
    .question-bubble-container {
        display: block;
        width: 100%;
        text-align: center;
        height: 264px;
        visibility: visible;
    }
    .addContainer .appAddQuestion .appAddBarPlacehoder {
        cursor: pointer;
        /*position: absolute;*/
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
        background: url("../../images/pencil.png") no-repeat;
        background-size: 80px auto;
        background-position: center;
    }
    .appAddQuestion {
        display: inline-block;
        width: 100%;
        max-width: 640px;
        position: relative;
        z-index: 1000;
    }
    .addContainer.placeholderActive {
        /*padding-top: 200px;*/
    }
    .page-in-app {
        display: inline-block;
        width: 100%;
        height: auto;
        /*padding: 40px 0 90px;*/
    }
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
        display: inline-block;
        margin-left: 120px;
        /*width: 100%;*/
        /*height: 100%;*/
        /*position: absolute;*/
        /*top: 0;*/
        /*left: 0;*/
    }
</style>