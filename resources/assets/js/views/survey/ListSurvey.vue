<template>
    <div>
        <div>
            <router-link :to="{name: 'WelcomePage'}">
                <el-button type="success" icon="el-icon-edit" size="medium">Create a Survey</el-button>
            </router-link>
        </div>
        <div>
            <el-table
                    v-loading="listLoading"
                    :data="listSurvey.filter(data => (!search && data.title !== null) || data.title.toLowerCase().includes(search.toLowerCase()))"
                    style="width: 90%">
                <el-table-column
                        label="Title"
                        width="600">
                    <template slot-scope="scope">
                            <a style="font-size: 16px; cursor:pointer;"
                              @click="handleEdit(scope.$index, scope.row)">{{scope.row.title}}</a>
                    </template>
                </el-table-column>
                <el-table-column>
                    <template slot-scope="scope">
                        <span class="custom-icon el-icon-edit-outline" title="Edit Survey"
                           @click="handleEdit(scope.$index, scope.row)"></span>
                        <span class="custom-icon el-icon-s-custom" title="Collect Response"
                           @click="handleDelete(scope.$index, scope.row)"></span>
                        <span class="custom-icon el-icon-s-data" title="Analyze Results"
                           @click="handleDelete(scope.$index, scope.row)"></span>
                    </template>
                </el-table-column>
                <el-table-column
                        align="right">
                    <template slot="header" slot-scope="scope">
                        <el-input
                                v-model="search"
                                size="mini"
                                placeholder="Type to search"/>
                    </template>
                    <template slot-scope="scope">
                        <el-switch
                                @change="changeStateActive(scope.row.id, scope.row.active)"
                                v-model="scope.row.active"
                                title = "ON"
                                active-color="#13ce66"
                                inactive-color="#e0e0d1">
                        </el-switch>
                        <span
                                class="custom-button-delete el-icon-delete-solid"
                                title="Delete"
                                size="mini"
                                type="danger"
                                @click="handleDelete(scope.$index, scope.row)"></span>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
    import {getListSurvey, deleteSurvey, changeStateActive} from "../../api/survey";

    export default {
        name: "ListSurvey",
        data(){
            return {
                listSurvey: [{
                }],
                search: '',
                listLoading: false,

            }
        },
        created() {
            this.$store.dispatch('deleteSurveyId')
            this.listLoading = true
            getListSurvey()
                .then(res => {
                    this.listSurvey = res.data.listSurvey
                    this.listSurvey = this.listSurvey.filter(survey => {
                        survey.active = Boolean(survey.active)
                        return survey
                    })
                    setTimeout(() => {
                        this.listLoading = false
                    }, 1.5 * 1000)
                })
                .catch(err => {
                    console.log(err)
                })
            setTimeout(() => {
                this.listLoading = false
            }, 1.5 * 1000)
        },
        methods: {
            handleEdit(index, row) {
                const surveyId = row.id
                this.$router.push({ name: 'WelcomePage', params: { surveyId }})
            },
            handleDelete(index, row) {
                const surveyId = row.id
                const data = {surveyId: surveyId}
                deleteSurvey(data)
                    .then(res => {
                        this.$notify({
                            title: 'Notification',
                            message: 'Success',
                            type: 'success',
                            duration: 2000
                        })
                        const index = this.listSurvey.indexOf(row)
                        this.listSurvey.splice(index, 1)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            changeStateActive(id, state) {
                const data = {surveyId: id, active: state}
                changeStateActive(data)
                    .then(res => {

                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        }
    }

</script>

<style scoped>
    .custom-icon {
        font-size:22px;
        cursor:pointer;
    }
    .custom-button-delete {
        font-size:16px;
        cursor:pointer;
        transform: translate(2px, 3px);
    }

</style>