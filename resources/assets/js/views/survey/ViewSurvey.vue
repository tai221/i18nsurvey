<template>
    <div class="custom-container">
        <div id="carouselExampleIndicators" class="carousel slide">

            <div class="carousel-inner">
                <div class="carousel-item welcome-page" v-bind:class="{active: startButton}">
                    <div class="title-survey row" style="margin-bottom: 30px;">
                        <div class="col-sm-5 col-sm-offset-5">
                            <h2 class="">{{survey.title}}</h2>
                        </div>
                    </div>
                    <div style="margin: auto; width: 15%;">
                        <h4>{{survey.dear}}</h4>
                    </div>
                    <div style="margin: auto; width: 35%; margin-bottom:40px;">
                        <h4>{{survey.greeting}}</h4>
                    </div>
                    <div style="margin: auto; width: 12%;">
                        <el-button @click="changeStateStart()" class="button-start" type="primary" plain>Start Now</el-button>
                    </div>

                </div>
<!--                <div v-for="" class="carousel-item" v-bind:class="{active: !startButton}">-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>-->
<!--                </div>-->
                <div class="carousel-item active question-page ">
                    <div class="box-question" >
                        <div class="title-question">
                            How old are you?<span style="color: red">*</span>
                        </div>
                        <div class="title-answer tick">
                            18 years old
                        </div>
                        <div class="title-answer">
                            19 years old
                        </div>
                        <div class="title-answer">
                            20 years old
                        </div>
                        <div class="other-answer">
                            <input type="text" value="Other answer">
                        </div>
                    </div>
                    <div class="box-question" >
                        <div class="title-question">
                            How far is it from your house to school? Write your answer to below...<span style="color: red">*</span>
                        </div>
                        <div class="other-answer">
                            <input type="text" value="Type one or a few words...">
                        </div>
                    </div>
                </div>
                <div class="carousel-item thanks-page">
                    <div style="margin: auto; width: 18%;">
                        <el-button @click="changeStateStart()" class="button-response" type="success" plain>Submit Response</el-button>
                    </div>
                    <div style="margin: auto; width: 40%; margin-bottom:40px; margin-top: 30px; color:#208000; ">
                        <h4><i>{{survey.thanks}}</i></h4>
                    </div>
                    <div style="margin: auto; width: 20%;">
                        <span>Click here: </span><a href="">{{survey.ref_url}}</a>
                    </div>
                </div>
            </div>
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
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
    import {fetchSurvey} from "../../api/survey";
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
                startButton: false,
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
                    console.log(res.data)
                    this.arrPage = res.data.arrPage
                    console.log(this.arrPage[0])
                })
        },
        methods: {
            changeStateStart() {
                this.startButton = false
            }
        }
    }
</script>

<style scoped>
    input[type=text]::after {
        content: url("../../images/input.png");
        transform: translate(378px, -5px);
    }
    .tick {
        display: flex;
    }
    .tick::after {
        content: url("../../images/tick.png");
        transform: translate(454px, 4px);
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
        width: 182px;
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
        height: -webkit-fill-available;
        padding-top: 5%;
        margin-bottom: 30px;
    }
    .custom-container {
        background-color: #accfe0;
        min-height: 672px;

    }
</style>.