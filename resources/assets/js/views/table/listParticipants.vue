<template>
    <div>
    <div class="app-container">
        <div class="con-cua-app-container">
        <div class="filter-container">
            <el-input placeholder="code" v-model="listQuery.code" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
            <el-input placeholder="email" v-model="listQuery.email" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
            <el-button-group>
                <el-button v-waves class="filter-item" type="primary" icon="el-icon-search" @click="handleFilter">Search</el-button>
                <el-button type="success" icon="el-icon-refresh-right" @click="resetList"></el-button>
            </el-button-group>
            <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="handleCreate">Add</el-button>
            <el-button  :loading="downloadLoading" class="filter-item" type="primary" icon="el-icon-download" @click="handleDownload">Export</el-button>
        </div>

        <el-table
                v-loading="listLoading"
                :key="tableKey"
                :data="list"
                :row-class-name="tableRowClassName"
                border
                fit
                style="width: 95%;"
                >
            <el-table-column label="CODE" prop="code"  align="center" width="65">
                <template slot-scope="scope">
                    <span>{{ scope.row.code }}</span>
                </template>
            </el-table-column>
            <el-table-column label="EMAIL" min-width="150px">
                <template slot-scope="scope">
                    <span>{{ scope.row.email }}</span>
                </template>
            </el-table-column>
            <el-table-column label="MODIFIED" width="160px" align="center">
                <template slot-scope="scope">
                    <span>{{ scope.row.updated_at | parseTime('{y}-{m}-{d} {h}:{i}')}}</span>
                </template>
            </el-table-column>
            <el-table-column label="ACTION" align="center" width="230" class-name="small-padding fixed-width">
                <template slot-scope="scope">
                    <el-button v-if="!scope.row.active" size="mini" type="warning" @click="unLockEmail(scope.row.id, scope.row)">Lock
                    </el-button>
                    <el-button v-if="scope.row.active" size="mini" @click="lockEmail(scope.row.id, scope.row)">Lock
                    </el-button>
                    <el-button  size="mini" type="danger" @click="handleDelete(scope.row, scope.row.id)">Delete
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog title="CREATE" :visible.sync="dialogFormVisible">
            <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="70px" style="width: 400px; margin-left:50px;">
                <el-form-item label="Code" prop="code">
                    <el-input v-model="temp.code"/>
                </el-form-item>
                <el-form-item label="Email" prop="email">
                    <el-input v-model="temp.email"/>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Cancel</el-button>
                <el-button type="primary" @click="createData()">Create</el-button>
            </div>
        </el-dialog>

        </div>
    </div>
        <Footer></Footer>
    </div>
</template>

<script>
    import { create, fetchList } from '../../api/participant'
    import waves from '../../directive/waves' // Waves directive
    import Pagination from '../../components/Pagination' // Secondary package based on el-pagination
    import Footer from "../../components/Footer";
    import {deleteParticipant, lockMail, unlockMail} from "../../api/participant";
    import {export_json_to_excel} from "../../vendor/Export2Excel";


    export default {
        name: 'ListParticipant',
        components: {
            Pagination ,
            Footer,
        },
        directives: { waves },
        watch: {

        },
        data() {
            return {
                tableKey: 0,
                listTotal: null,
                list: null,
                total: 0,
                listLoading: false,
                listQuery: {
                    page: 1,
                    limit: 10,
                    email: undefined,
                    code: undefined,
                },
                temp: {
                    code: '',
                    updated_at: new Date(),
                    email: '',
                    active: true,
                },
                dialogFormVisible: false,
                rules: {
                    code: [{ required: true, message: 'code is required', trigger: 'blur' }],
                    email: [{ required: true, message: 'email is required', trigger: 'blur' }]
                },
                downloadLoading: false
            }
        },
        created() {
            this.$store.dispatch('deleteSurveyId')
            this.getList()
        },
        methods: {
            getList() {
                this.listLoading = true
                fetchList(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.listTotal = response.data.items
                    this.total = response.data.total
                    console.log(this.list)
                    setTimeout(() => {
                        this.listLoading = false
                    }, 1 * 1000)
                })
            },
            handleFilter() {
                this.list = this.listTotal
                if(this.listQuery.email) {
                    this.list = this.list.filter(email => email.email.toLowerCase().includes(this.listQuery.email.toLowerCase()))
                }
                if(this.listQuery.code) {
                    this.list = this.list.filter(email => email.code.toLowerCase().includes(this.listQuery.code.toLowerCase()))
                }
            },
            resetList(){
                this.list = this.listTotal
            },
            resetTemp() {
                this.temp = {
                    code: '',
                    updated_at: new Date(),
                    email: '',
                    active: true,
                }
            },
            handleCreate() {
                this.resetTemp()
                this.dialogFormVisible = true
                this.$nextTick(() => {
                    this.$refs['dataForm'].clearValidate()
                })
            },
            createData() {
                this.$refs['dataForm'].validate((valid) => {
                    if (valid) {
                        create(this.temp).then(() => {
                            this.list.unshift(this.temp)
                            this.dialogFormVisible = false
                            this.$notify({
                                title: 'Notification',
                                message: 'Success',
                                type: 'success',
                                duration: 2000
                            })
                        })
                    }
                })
            },
            handleDelete(row, id) {
                const data = {idEmail: id}
                deleteParticipant(data)
                    .then(res => {
                        this.$notify({
                            title: 'Notification',
                            message: 'Success',
                            type: 'success',
                            duration: 2000
                        })
                        const index = this.list.indexOf(row)
                        this.list.splice(index, 1)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            handleDownload() {
                this.downloadLoading = true
                    const tHeader = ['code', 'email', 'active', 'modified at']
                    const filterVal = ['code', 'email', 'active', 'updated_at']
                    const data = this.formatJson(filterVal, this.list)
                    export_json_to_excel({
                        header: tHeader,
                        data,
                        filename: 'list-participant'
                    })
                    this.downloadLoading = false
            },
            formatJson(filterVal, jsonData) {
                return jsonData.map(v => filterVal.map(j => {
                    if (j === 'active') {
                        if(v[j]==1) return 'Yes';
                        return 'No'
                    } else {
                        return v[j]
                    }
                }))
            },
            lockEmail(id, row) {
                const data = {idEmail: id}
                lockMail(data)
                    .then(res => {
                        const index = this.list.indexOf(row)
                        this.list[index].active = 0
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            unLockEmail(id, row) {
                const data = {idEmail: id}
                unlockMail(data)
                    .then(res => {
                        const index = this.list.indexOf(row)
                        this.list[index].active = 1
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            tableRowClassName({row, rowIndex}) {
                if (row.active === 0) {
                    return 'inactive-row';
                }
            }
        }
    }
</script>

<style>
    .el-table .inactive-row {
        background: #d7d9de;
    }
</style>
