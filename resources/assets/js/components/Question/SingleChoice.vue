<template>
    <el-dialog :visible.sync="dialogVisible" :close="close">
        <el-input v-model="question" placeholder="Write your question here..." size="medium"></el-input>
        <div class="note"><i>Select one answer</i></div>
        <div v-for="(answer,n) in answers" class="row-answer" >
            <el-input class="answer"
                    v-model="answers[n].answer"
                    :placeholder="'answer '+(n+1)"
                    size="mini"
                    :key="n">
            </el-input>
            <div class="icon-garbage" @click="deleteAnswer(n)">
                <i class="el-icon-delete"></i>
            </div>
        </div>
        <div class="row-answer" v-if="!hiddenOtherAnswer">
            <el-input
                    class="answer"
                    v-model="otherAnswer"
                    placeholder="Other answer"
                    size="mini"></el-input>
            <el-input
                    class="answer"
                    :disabled="true"
                    size="mini"></el-input>
            <div class="icon-garbage" @click="hiddenOtherAnswer=false">
                <i class="el-icon-delete"></i>
            </div>
        </div>
        <div class="two-button">
            <el-button class="button-add"
                       @click="addAnswer"
                       type="primary"
                       size="mini"
                       icon="el-icon-circle-plus-outline"
                       round
                       plain>Add answer</el-button>
            <el-button class="button-add-other"
                       @click="hiddenOtherAnswer=true"
                       type="primary"
                       size="mini"
                       icon="el-icon-circle-plus-outline"
                       round
                       plain>Add 'Other' answer</el-button>
        </div>
        <div slot="footer" class="dialog-footer">
            <el-switch
                    v-model="isRequire"
                    active-text="Require">
            </el-switch>
            <el-button type="primary" @click="createQuestion()">Create</el-button>
        </div>
    </el-dialog>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import {create} from "../../api/question";

    export default {
        name: "SingleChoice",
        props: [
            'dialogVisible',
            'pageNumber',
            'orderPage',
        ],
        data() {
            return {
                questionId: null,
                question:'',
                answers:[
                    {answer:''},
                    {answer:''},
                    {answer:''},
                ],
                otherAnswer: 'Other answer',
                hiddenOtherAnswer: true,
                isRequire: false,
            }
        },
        computed: {
            ...mapGetters([
                'surveyId'
            ])
        },
        methods: {
            close() {
                this.$emit('SingleChoiceClose')
            },
            addAnswer() {
                this.answers.push({answer:''})
            },
            deleteAnswer(index) {
                this.answers.splice(index,1)
            },
            createQuestion() {
                const data = {
                    questionId: this.questionId,
                    question: this.question,
                    surveyId: this.surveyId,
                    required: this.isRequire,
                    type: 1,
                    page: this.$props.pageNumber,
                    orderPage: this.$props.orderPage,
                    hiddenOtherAnswer: this.hiddenOtherAnswer,
                    otherAnswer: this.otherAnswer,
                    answers: this.answers
                }
                create(data).then(response => {
                    console.log(response)
                })
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