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
                    <div style="margin: auto; width: 12%;">
                        <h4>{{survey.dear}}</h4>
                    </div>
                    <div style="margin: auto; width: 35%; margin-bottom:40px;">
                        <h4>{{survey.greeting}}</h4>
                    </div>
                    <div style="margin: auto; width: 12%;">
                        <el-button @click="changeStateStart()" class="button-start" type="primary" plain>Start Now</el-button>
                    </div>

                </div>
                <div v-for="" class="carousel-item" v-bind:class="{active: !startButton}">
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                    <div >aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa </div>
                </div>
                <div class="carousel-item">
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
                    <div   >aaaaaaaaaaaaaaaaaaaaaaaa</div>
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
                startButton: true,
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
    .button-start {
        width: 142px;
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
    .custom-container {
        background-color: #cee4ef;
        min-height: 672px;

    }
</style>.