<template>
    <div class="custom-container">
        <div id="carouselExampleIndicators" class="carousel slide" data-interval="false">

            <div class="carousel-inner">

                <div class="carousel-item welcome-page" v-bind:class="{active: startButton}">
                    <div class="title-survey row" style="margin-bottom: 30px;">
                        <div style="margin: auto; width: 25%; text-align:center;">
                            <h2 class="">{{survey.title}}</h2>
                        </div>
                    </div>
                    <div style="margin: auto; width: 15%; text-align:center;">
                        <h4>{{survey.dear}}</h4>
                    </div>
                    <div style="margin: auto; width: 35%; margin-bottom:40px; text-align:center;">
                        <h4>{{survey.greeting}}</h4>
                    </div>
                    <div style="margin: auto; width: 12%;">
                        <el-button @click="changeStateStart()" class="button-start" type="primary" plain>Start Now</el-button>
                    </div>
                </div>

                <div v-for="(page, indexPage) in arrPage" class="carousel-item question-page" v-bind:class="{active: !startButton && indexPage == 0}">
                    <div v-for="(question, indexQuestion) in page">
                        <div v-if="question.type == 1" class="box-question" >
                            <div class="title-question">
                                {{indexQuestion+1}}. {{question.question}}<span v-if="question.required" style="color: red">*</span>
                            </div>
                            <div   v-for="(answer, index) in question.answers"
                                   :key="index"
                                   :class="[answer.key == 100? 'other-answer':'title-answer', { tick: arrPage[indexPage][indexQuestion].tick==answer.key}] "
                                   @click="tickAnswer(indexPage, indexQuestion, answer.key)">
                                <span  v-if="answer.key !== 100">{{answer.content}}</span>
                                <input v-if="answer.key == 100" v-model="answer.content" type="text">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item thanks-page">
                    <div style="margin: auto; width: 18%;">
                        <el-button @click="submit()" class="button-response" type="success" plain v-bind:disabled="isSubmit">Submit Response</el-button>
                    </div>
                    <div v-if="isSubmit" style="margin: auto; width: 40%; margin-bottom:40px; margin-top: 30px; color:#208000; ">
                        <h4><i>{{survey.thanks}}</i></h4>
                    </div>
                    <div v-if="isSubmit" style="margin: auto; width: 20%;">
                        <span v-if="survey.ref_url!==null">Click here: </span><a href="">{{survey.ref_url}}</a>
                    </div>
                </div>

            </div>
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                <li v-for="i in countPage" data-target="#carouselExampleIndicators" data-slide-to=""></li>
            </ol>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</template>

<script>
    import {countPage, fetchSurvey, submitResponse} from "../../api/survey";
    import {getAllQuestions} from "../../api/question";

    export default {
        name: "ViewSurvey",
        data() {
            return {
                countPage: undefined,
                survey: {
                    start_date: undefined,
                    expire: undefined,
                    title: undefined,
                    dear: 'Dear Sir / Madam,',
                    greeting: 'Thank you for visiting us. By filling out this 5-10 minute survey, you will help us obtain the very best results.',
                    surveyId: undefined,
                    thanks: undefined,
                    ref_url: undefined,
                },
                arrPage:[],
                startButton: true,
                isSubmit: false,
            }
        },
        created() {
            let surveyId = this.$route.params.surveyId
            fetchSurvey(surveyId).then(response => {
                    let {title, dear, greeting, thanks, ref_url} = response.data.survey
                    this.survey.title = title
                    this.survey.dear = dear
                    this.survey.greeting = greeting
                    this.survey.thanks = thanks
                    this.survey.ref_url = ref_url
            })
            const data = {surveyId: surveyId}
            getAllQuestions(data)
                .then(res => {
                    this.arrPage = res.data.arrPage
                    this.countPage = this.arrPage.length+1
                    this.arrPage = this.arrPage.map(page => {
                       page = page.map(question => {
                           question.tick = null
                           return question
                       })
                        return page
                    });
                })
        },
        methods: {
            changeStateStart() {
                this.startButton = false
            },
            submit() {
                var allResponse = [];
                for(let i = 0; i< this.arrPage.length; i++) {
                    for(let j = 0; j < this.arrPage[i].length; j++) {
                        if(this.arrPage[i][j].required == 1 && this.arrPage[i][j].tick == null) {
                            this.$notify({
                                title: 'Notification',
                                message: 'Some questions have not been completed',
                                type: 'warning',
                                duration: 4000
                            })
                            return
                        }
                        var answer = this.arrPage[i][j].tick
                        if(this.arrPage[i][j].type == 1 && this.arrPage[i][j].tick == 100) {
                            let temp = this.arrPage[i][j].answers.filter(answer => {
                                return answer.key == 100
                            })
                            answer = temp[0].content
                        }
                        let response = {
                            question_id: this.arrPage[i][j].id,
                            answer: answer,
                        }
                        allResponse.push(response)
                    }
                }
                const data = {
                    surveyId: this.$route.params.surveyId,
                    emailId: this.$route.params.emailId,
                    allResponse: allResponse,
                }
                console.log(data)
                submitResponse(data)
                    .then(res => {
                        this.$notify({
                            title: 'Notification',
                            message: 'Success',
                            type: 'success',
                            duration: 3000
                        })
                        this.isSubmit = true
                    })
            },
            tickAnswer(indexPage, indexQuestion, answerKey){
                this.arrPage[indexPage][indexQuestion].tick = answerKey
            }
        }
    }
</script>

<style scoped>
    input[type=text]::after {
        content: url("../../images/input.png");
        transform: translate(378px, -5px);
    }
    /*.tick {*/
    /*    display: flex;*/
    /*}*/
    .tick::after {
        content: url("../../images/tick.png");
        /*transform: translate(454px, 4px);*/
        right: 389px;
        position: absolute;
        margin-top: 6px;
    }
    input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 1px 0;
        box-sizing: border-box;
        border: none;
        background-color: #3CBC8D;
        color: white;
        border-radius: 5px;
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
    .title-question {
        font-size: 24px;
        color: black;
        text-align: left;
    }
    .box-question {
        border: 0.25px solid;
        width: 45%;
        padding: 20px 10px 10px 10px;
        margin: auto;
        background-color: #ccffcc;
        margin-top: 30px;
    }
    .box-question:hover {
        cursor: pointer;
    }
    .button-start {
        width: 142px;
        border-radius: 5px;
        height: 50px;
        font-size: 20px;
    }
    .button-response {
        width: 185px;
        border-radius: 5px;
        height: 50px;
        font-size: 20px;
    }
    .carousel-control-next, .carousel-control-prev {
        position: absolute;
        /*top: 340px;*/
        /* bottom: 0; */
        z-index: 1;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 15%;
        color: #fff;
        text-align: center;
        opacity: .5;
        transition: opacity .15s ease;
    }
    .welcome-page {
        height: -webkit-fill-available;
        padding-top: 10%;
        margin-bottom: 30px;
    }
    .thanks-page {
        height: -webkit-fill-available;
        padding-top: 20%;
        margin-bottom: 30px;
    }
    .question-page {
        /*height: -webkit-fill-available;*/
        padding-top: 5%;
        margin-bottom: 60px;
    }
    .custom-container {
        background-color: #accfe0;
        min-height: 672px;

    }
</style>.