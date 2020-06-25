<template>
    <el-dialog :visible.sync="mutableVisableRateChoice" :close="close" >
        <el-input v-model="question" placeholder="Write your question here..." size="medium"></el-input>
        <div class="note"><i>Rate answer</i></div>
        <el-rate
                :texts="['oops', 'disappointed', 'normal', 'good', 'great']"
                show-text>
        </el-rate>
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
            answers:[
                {
                    content:'1',
                    id: null,
                    key: 1
                },
                {
                    content:'2',
                    id: null,
                    key: 2
                },
                {
                    content:'3',
                    id: null,
                    key: 3
                },
                {
                    content:'4',
                    id: null,
                    key: 4
                },
                {
                    content:'5',
                    id: null,
                    key: 5
                }
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
        name: "RateChoice",
        props: [
            'visableRateChoice',
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
            mutableVisableRateChoice: {
                get: function(){
                    return this.$props.visableRateChoice
                },
                set: function(value){
                    this.$props.visableRateChoice = value
                    this.$emit('RateChoiceClose')
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
                this.$emit('RateChoiceClose')
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
                const data = {
                    questionId: this.questionId,
                    question: this.question,
                    surveyId: this.surveyId,
                    required: this.isRequire,
                    type: 2,
                    page: this.$props.pageNumber,
                    orderPage: this.$props.orderPage,
                    // hiddenOtherAnswer: this.hiddenOtherAnswer,
                    // otherAnswer: this.otherAnswer,
                    answers: this.answers
                }
                create(data)
                    .then(response => {
                        this.mutableVisableRateChoice = false
                        // if(!this.hiddenOtherAnswer) {
                        //     this.answers.push(
                        //         this.otherAnswer
                        //     )
                        // }
                        const question = {
                            required: this.isRequire,
                            type: 2,
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
        }
    }
</script>

<style scoped>

</style>