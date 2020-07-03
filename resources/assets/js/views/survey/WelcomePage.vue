<template>
    <div class="page-in">
        <div class="align">
            <div class="block">
                <div class="block-in block-in-center">
                    <div class="h1-container" style="color:#000;">
                        <textarea v-on:keyup="keyup" v-on:keydown="keydown" v-model="survey.title" maxlength="400" rows="1" class="h1" placeholder="Survey Title..." style="height: 33px;">
                            </textarea>
                    </div>
                    <div>
                        <div class="DraftEditor-root DraftEditor-alignCenter">
                            <div class="DraftEditor-editorContainer">
                                <div aria-describedby="placeholder-55jr" class="notranslate public-DraftEditor-content" contenteditable="true" role="textbox" spellcheck="false" style="outline:none;user-select:text;-webkit-user-select:text;white-space:pre-wrap;word-wrap:break-word;">
                                    <div data-contents="true">
                                        <div class="" data-block="true" data-editor="55jr" data-offset-key="carcn-0-0">
                                            <div data-offset-key="carcn-0-0" class="public-DraftStyleDefault-block public-DraftStyleDefault-ltr">
                                                <span data-offset-key="carcn-0-0">
                                                    <el-input v-model="survey.dear"
                                                              v-on:change="keyup"
                                                              v-bind:class="{'border':border}"
                                                              data-text="true">
                                                    </el-input>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="" data-block="true" data-editor="55jr" data-offset-key="34t1t-0-0">
                                            <div data-offset-key="34t1t-0-0" class="public-DraftStyleDefault-block public-DraftStyleDefault-ltr">
                                                <span data-offset-key="34t1t-0-0" >
                                                     <el-input type="textarea"
                                                               :rows="2"
                                                               v-model="survey.greeting"
                                                               v-on:change="keyup"
                                                               data-text="true">
                                                    </el-input>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <el-button class="button-start" type="primary" plain>Start Now</el-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {create, fetchSurvey} from "../../api/survey";
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: "WelcomePage",
        data() {
            return  {
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
                border: true,
                typingTimer: '',
                doneTypingInterval: 500,
            }
        },
        computed: {
            ...mapGetters([
                'surveyId',
            ])
        },
        // watch: {
        //     survey: {
        //         handler(){
        //             this.createOrUpdate()
        //         },
        //         deep: true
        //     }
        //
        // },
        created() {
            var surveyId = this.surveyId
            if(this.$route.params.surveyId > 0){
                surveyId = this.$route.params.surveyId
                this.$store.dispatch('setSuveyId', surveyId)
            }
            fetchSurvey(surveyId).then(response => {
                if(response.data.survey) {
                    let {title, dear, greeting, thanks, ref_url} = response.data.survey
                    this.survey.title = title
                    this.survey.dear = dear
                    this.survey.greeting = greeting
                    this.survey.thanks = thanks
                    this.survey.ref_url = ref_url
                } else {
                    this.createOrUpdate()
                }
            })
        },
        methods: {
            createOrUpdate() {
                this.survey.surveyId = this.surveyId
                create(this.survey).then(response => {
                    let survey_id = response.data.survey_id
                    this.$store.dispatch('setSuveyId', survey_id)
                    this.$message({
                        message: 'Saved',
                        type: 'success',
                        duration: 1000,
                    });
                })
            },
            keyup() {
                clearTimeout(this.typingTimer);
                this.typingTimer = setTimeout(this.doneTyping, this.doneTypingInterval);
            },
            keydown() {
                clearTimeout(this.typingTimer);
            },
            doneTyping () {
                this.createOrUpdate()
            }
        }
    }
</script>

<style scoped>
    .DraftEditor-editorContainer .border {
        -webkit-appearance: none;
        border: 0;
    }
    /*.DraftEditor-editorContainer input.border {*/
    /*    !*-webkit-appearance: none;*!*/
    /*    border: 1px;*/
    /*}*/
    .button-start {
        width: 120px;
        border-radius: 5px;
    }
    .DraftEditor-alignCenter .public-DraftStyleDefault-block {
        text-align: center;
    }
    .public-DraftStyleDefault-ltr {
        direction: ltr;
        text-align: left;
    }
    .public-DraftStyleDefault-block {
        position: relative;
        white-space: pre-wrap;
    }
    .public-DraftStyleDefault-block {
        margin-bottom: .8em;
    }
    .public-DraftEditor-content[contenteditable=true] {
        -webkit-user-modify: read-write-plaintext-only;
    }
    .DraftEditor-editorContainer {
        background-color: hsla(0,0%,100%,0);
        border-left: .1px solid transparent;
        position: relative;
        z-index: 1;
    }
    .editor .DraftEditor-root, .editor .redactor-box {
        width: 100%;
        line-height: 1.6em;
        font-size: 16px;
        resize: none;
        padding: 6px 15px;
        overflow: hidden;
        background: transparent;
        z-index: 2;
        vertical-align: baseline;
        position: relative;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .DraftEditor-root {
        position: relative;
    }
    .DraftEditor-editorContainer, .DraftEditor-root, .public-DraftEditor-content {
        height: inherit;
        text-align: initial;
    }
    .editor:after {
        top: 1px;
        left: 1px;
        width: calc(100% - 2px);
        height: calc(100% - 2px);
    }
    .editor:after, .editor:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        width: 100%;
        height: 100%;
        border: 1px dashed transparent;
        -webkit-transition: border-color .15s ease-in-out;
        -moz-transition: border-color .15s ease-in-out;
        -o-transition: border-color .15s ease-in-out;
        transition: border-color .15s ease-in-out;
    }
    .editor {
        padding: 0;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .editor, .editorOutContainer {
        position: relative;
        display: block;
    }
    .h1-container:after {
        border-color: hsla(0,0%,100%,.3);
        width: 100%;
        height: 100%;
        top: 1px;
        left: 1px;
        width: calc(100% - 2px);
        height: calc(100% - 2px);
    }
    button, input, select, textarea {
        font-size: 14px;
        font-weight: 400;
        outline: none;
        border-radius: 0;
        -webkit-appearance: none;
        width: 100%;
        background: none;
    }
    .h1-container textarea.h1 {
        position: relative;
        z-index: 20;
        color: inherit;
        font-size: inherit;
    }
    textarea.h1 {
        background-color: transparent;
        resize: none;
        overflow: hidden;
        text-align: center;
        border: 0;
        padding: 0;
        font-size: 24px;
    }
     .h1-container:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 1px dashed rgba(0,0,0,.3);
        z-index: 10;
        opacity: 0;
        filter: alpha(opacity=0);
        -webkit-transition: opacity .15s ease-in-out;
        -moz-transition: opacity .15s ease-in-out;
        -o-transition: opacity .15s ease-in-out;
        transition: opacity .15s ease-in-out;
    }
    .h1-container {
        margin-top: 5px;
        padding-top: 19px;
        padding-bottom: 10px;
        display: block;
        font-size: 24px;
        position: relative;
    }
    .logoContainer .imagePicker .placeholder span {
        display: block;
        padding: 13px 0 0;
        font-size: 14px;
    }
    .icon-image:before {
        content: "\E907";
    }
    [class*=" icon-"], [class^=icon-] {
        font-family: icomoon!important;
        speak: none;
        font-style: normal;
        font-weight: 400;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .logoContainer .imagePicker .placeholder .icon-image {
        font-size: 35px;
        display: block;
        width: 50px;
        height: 30px;
        margin: 20px auto 0;
    }
    .logoContainer .imagePicker .placeholder {
        width: 100%;
        cursor: pointer;
        height: 100%;
        color: #000;
    }
    .imagePicker img, .imagePicker label {
        opacity: 1;
        filter: alpha(opacity=100);
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .uploadLoader {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        visibility: hidden;
        z-index: 100;
        -webkit-transition: all .3s cubic-bezier(.32,.82,.57,.21);
        -moz-transition: all .3s cubic-bezier(.32,.82,.57,.21);
        -o-transition: all .3s cubic-bezier(.32,.82,.57,.21);
        transition: all .3s cubic-bezier(.32,.82,.57,.21);
        opacity: 0;
        filter: alpha(opacity=0);
        -webkit-transform: rotateY(-45deg);
        -moz-transform: rotateY(-45deg);
        -ms-transform: rotateY(-45deg);
        -o-transform: rotateY(-45deg);
        transform: rotateY(-45deg);
    }
    .logoContainer .imagePicker {
        border: 1px dashed rgba(0,0,0,.3);
        width: 100%;
        height: 100%;
        text-align: center;
        position: relative;
        cursor: pointer;
    }
    .logoContainer, .logoContainer .imagePicker {
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .logoContainer {
        top: 0!important;
        border: 1px dashed transparent;
        width: 204px!important;
        height: 99px!important;
        margin: 56px 25px 0 0;
        border: 1px dashed hsla(0,0%,100%,.3);
    }
    .logoContainer {
        margin: 0;
        position: static;
        display: inline-block;
    }
    .block .block-in.block-in-center {
        text-align: center;
    }
    .block .block-in {
        padding-top: 10px;
        padding-bottom: 30px;
    }
    .page-in .block .block-in {
        position: relative;
    }
    @media (min-width: 620px){
        .page-in .block-in {
            max-width: 600px;
        }
    }
    @media only screen and (min-width: 0) {
        .page-in .block-in {
            display: inline-block;
            width: 100%;
            max-width: 516px;
            text-align: left;
        }
    }
    /*.block {*/
    /*    padding-top: 0;*/
    /*    padding-bottom: 0;*/
    /*    position: relative;*/
    /*    z-index: 50;*/
    /*    display: block;*/
    /*    width: 100%;*/
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