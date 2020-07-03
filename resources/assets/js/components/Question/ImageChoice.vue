<template>
    <el-dialog :visible.sync="mutableVisableImageChoice" :close="close" >
        <el-input v-model="question" placeholder="Write your question here..." size="medium"></el-input>
        <div class="note"><i>Select one image</i></div>
        <el-upload
                class="upload-demo"
                action="http://127.0.0.1:8000/api/image/upload"
                :on-preview="handlePreview"
                :on-remove="handleRemove"
                :on-success="uploadSuccess"
                :file-list="fileList"
                list-type="picture">
            <el-button size="small" type="primary">Click to upload</el-button>
            <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
        </el-upload>
<!--        <div v-for="(answer,n) in answers" class="row-answer" >-->
<!--            <el-input class="answer"-->
<!--                      v-model="answers[n].content"-->
<!--                      :placeholder="'answer '+(n+1)"-->
<!--                      size="mini"-->
<!--                      :key="n">-->
<!--            </el-input>-->
<!--            <div class="icon-garbage" @click="deleteAnswer(n)">-->
<!--                <i class="el-icon-delete"></i>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="row-answer" v-if="!hiddenOtherAnswer">-->
<!--            <el-input-->
<!--                    class="answer"-->
<!--                    v-model="otherAnswer.content"-->
<!--                    placeholder="Other answer"-->
<!--                    size="mini"></el-input>-->
<!--            <el-input-->
<!--                    class="answer"-->
<!--                    :disabled="true"-->
<!--                    size="mini"></el-input>-->
<!--            <div class="icon-garbage" @click="hiddenOtherAnswer=true">-->
<!--                <i class="el-icon-delete"></i>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="two-button">-->
<!--            <el-button class="button-add"-->
<!--                       @click="addAnswer"-->
<!--                       type="primary"-->
<!--                       size="mini"-->
<!--                       icon="el-icon-circle-plus-outline"-->
<!--                       round-->
<!--                       plain>Add answer</el-button>-->
<!--            <el-button class="button-add-other"-->
<!--                       @click="hiddenOtherAnswer=false"-->
<!--                       type="primary"-->
<!--                       size="mini"-->
<!--                       icon="el-icon-circle-plus-outline"-->
<!--                       round-->
<!--                       plain>Add 'Other' answer</el-button>-->
<!--        </div>-->
        <div slot="footer" class="dialog-footer">
            <el-switch
                    v-model="isRequire"
                    active-text="Require">
            </el-switch>
            <el-button type="primary" @click="createQuestion()">{{ this.idQuestion > 0 ? 'Update' : 'Create'}}</el-button>
        </div>
    </el-dialog>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import {create, getQuestion} from "../../api/question";
    function initialState (){
        return {
            questionId: null,
            question:'',
            fileList: [],
            answers:[
                // {
                //     content:'',
                //     id: null,
                //     key: null
                // },
                // {
                //     content:'',
                //     id: null,
                //     key: null
                // },
                // {
                //     content:'',
                //     id: null,
                //     key: null
                // },
            ],
            // otherAnswer: {
            //     content: 'Other answer',
            //     id: null,
            //     key: 100,
            // },
            // hiddenOtherAnswer: true,
            isRequire: false,
        }
    }
    export default {
        name: "ImageChoice",
        props: [
            'visableImageChoice',
            'pageNumber',
            'orderPage',
            'idQuestion',
        ],
        data() {
            return initialState();
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ]),
            mutableVisableImageChoice: {
                get: function(){
                    return this.$props.visableImageChoice
                },
                set: function(value){
                    this.$props.visableImageChoice = value
                    this.$emit('ImageChoiceClose')
                }
            }
        },
        watch: {
            idQuestion: function() {
                console.log('watch id question')
                const data = {
                    idQuestion: this.idQuestion
                }
                getQuestion(data).then( resp => {
                    this.questionId = resp.data.question[0].id
                    this.question = resp.data.question[0].question
                    this.isRequire = Boolean(resp.data.question[0].required)
                    // let answers = resp.data.question.answers
                    // this.answers = []
                    // for(let i = 0; i < answers.length; i++) {
                    //     if(answers[i].key == 100 ) {
                    //         this.hiddenOtherAnswer = false
                    //         this.otherAnswer = answers[i]
                    //     } else{
                    //         this.answers.push(answers[i])
                    //     }
                    // }
                })
            }
        },
        methods: {
            close() {
                this.$emit('ImageChoiceClose')
            },
            // addAnswer() {
            //     this.answers.push(
            //         {
            //             content:'',
            //             id: null,
            //             key: null,
            //         }
            //     )
            // },
            // deleteAnswer(index) {
            //     this.answers.splice(index,1)
            // },
            createQuestion() {
                for(let i = 0; i < this.fileList.length; i++) {
                    let temp = {content:this.fileList[i].name+'*'+this.fileList[i].url, id:null, key:null}
                    this.answers.push(temp)
                }
                const data = {
                    questionId: this.questionId,
                    question: this.question,
                    surveyId: this.surveyId,
                    required: this.isRequire,
                    type: 3,
                    page: this.$props.pageNumber,
                    orderPage: this.$props.orderPage,
                    // hiddenOtherAnswer: this.hiddenOtherAnswer,
                    // otherAnswer: this.otherAnswer,
                    answers: this.answers
                }
                console.log(data)
                create(data)
                    .then(response => {
                        this.mutableVisableImageChoice = false
                        // if(!this.hiddenOtherAnswer) {
                        //     this.answers.push(
                        //         this.otherAnswer
                        //     )
                        // }
                        const question = {
                            required: this.isRequire,
                            type: 3,
                            question: this.question,
                            id: response.data.question_id,
                            page: this.$props.pageNumber,
                            order_page: this.$props.orderPage,
                            answers: this.answers
                        }
                        if(this.questionId == null) {
                            this.$emit('addQuestion', question)
                        } else {
                            this.$emit('updateQuestion', question)
                        }
                        Object.assign(this.$data, initialState());
                        this.$notify({
                            title: 'Notification',
                            message: 'Success',
                            type: 'success',
                            duration: 2000
                        })
                    })
                    .catch(resp => {
                        this.$notify({
                            title: 'Notification',
                            message: 'Fail',
                            type: 'Fail',
                            duration: 2000
                        })
                    })
            },
            handleRemove(file, fileList) {
                this.fileList = this.fileList.filter(temp => {
                    return temp.url !== file.url
                })
            },
            handlePreview(file) {
                console.log(file);
            },
            uploadSuccess(response, file, fileList) {
                const data = {name:file.name, url:file.response.pathFile}
                this.fileList.push(data)
            }
        }

    }
</script>

<style scoped>

    .el-switch {
        margin-right: 20px;
    }
    .icon-garbage:hover {
        cursor: pointer;
    }
    .icon-garbage {
        padding-top: 5px;
    }
    .button-add-other .answer .button-add .icon-garbage{
        display: flex;
    }
    .two-button {
        display:-webkit-box;
    }
    .row-answer {
        margin-top: 10px;
        margin-bottom: 5px;
        display:flex;
    }
    .note {
        display: flex;
        margin-left: 15px;
        margin-top: 10px;
        margin-bottom: 6px;
    }
</style>