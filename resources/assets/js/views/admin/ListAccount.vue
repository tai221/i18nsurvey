<template>
    <div>
        <div class="app-container">
            <div class="con-cua-app-container">
                <div class="filter-container">
                    <el-input placeholder="username" v-model="listQuery.name" style="width: 200px;" class="filter-item" @keyup.enter.native="handleFilter"/>
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
                    <el-table-column label="NAME" prop="name"  align="center" width="80">
                        <template slot-scope="scope">
                            <span>{{ scope.row.name }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="EMAIL" min-width="140px">
                        <template slot-scope="scope">
                            <span>{{ scope.row.email }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="ROLE" min-width="60px">
                        <template slot-scope="{row}">
                            <template v-if="row.edit">
                                <el-select v-model="row.role" class="filter-item" placeholder="Please select">
                                    <el-option v-for="(item,index) in roleOptions" v-bind:class="[Boolean(index) ? user: admin]" :key="index" :label="item" :value="index+1"/>
                                </el-select>
                                <el-button class="cancel-btn" size="mini" icon="el-icon-refresh" type="warning" @click="cancelEdit(row)">
                                    cancel
                                </el-button>
                            </template>
                            <span v-else-if="row.role == 1" style="color: #00BF6F">{{ row.role | roleFilter}}</span>
                            <span v-else-if="row.role == 2" style="color: red">{{ row.role | roleFilter}}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="CREATED AT" width="160px" align="center">
                        <template slot-scope="scope">
                            <span>{{ scope.row.created_at | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="UPDATED AT" width="160px" align="center">
                        <template slot-scope="scope">
                            <span>{{ scope.row.updated_at | parseTime('{y}-{m}-{d} {h}:{i}') }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column label="ACTION" align="center" width="230" class-name="small-padding fixed-width">
                        <template slot-scope="{row}">
                            <el-button v-if="!row.activated" size="mini" type="warning" @click="unLockAccount(row.id, row)">Lock
                            </el-button>
                            <el-button v-if="row.activated" size="mini" @click="lockAccount(row.id, row)">Lock
                            </el-button>
                            <el-button v-if="row.edit" type="success" size="mini" icon="el-icon-circle-check-outline" @click="confirmEdit(row)">
                                Ok
                            </el-button>
                            <el-button v-else type="primary" size="mini" icon="el-icon-edit" @click="row.edit=!row.edit">
                                Edit
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

                <el-dialog title="CREATE ACCOUNT" :visible.sync="dialogFormVisible">
                    <el-form ref="dataForm" :rules="rules" :model="temp" label-position="left" label-width="70px" style="width: 400px; margin-left:50px;">
                        <el-form-item label="Username" prop="name" label-width="120px">
                            <el-input v-model="temp.name"/>
                        </el-form-item>
                        <el-form-item label="Email" prop="email" label-width="120px">
                            <el-input v-model="temp.email"/>
                        </el-form-item>
                        <el-form-item label="Password" prop="password" label-width="120px">
                            <el-input v-model="temp.password"/>
                        </el-form-item>
                        <el-form-item label="Role" prop="role" label-width="120px">
                            <el-select v-model="temp.role" class="filter-item" placeholder="Please select">
                                <el-option v-for="(item,index) in roleOptions" :key="index" :label="item" :value="index+1"/>
                            </el-select>
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
    import { createAccount, fetchListAccount, changeRole, lockAccount, unlockAccount} from '../../api/account'
    import waves from '../../directive/waves' // Waves directive
    import Pagination from '../../components/Pagination' // Secondary package based on el-pagination
    import Footer from "../../components/Footer";
    import {export_json_to_excel} from "../../vendor/Export2Excel";


    export default {
        name: 'ListAccount',
        components: {
            Pagination ,
            Footer,
        },
        directives: { waves },
        filters: {
            roleFilter(role) {
                const roleMap = {
                    1: 'User',
                    2: 'Admin',
                }
                return roleMap[role]
            },
        },
        watch: {

        },
        data() {
            return {
                roleOptions: [ 'User', 'Admin'
                ],
                user:'user',
                amdin: 'admin',
                tableKey: 0,
                listTotal: null,
                list: null,
                total: 0,
                listLoading: false,
                listQuery: {
                    page: 1,
                    limit: 10,
                    name: undefined,
                    email: undefined,
                },
                temp: {
                    name: '',
                    email: '',
                    password: '',
                    role: undefined,
                },
                dialogFormVisible: false,
                rules: {
                    name: [{ required: true, message: 'Username is required', trigger: 'blur' }],
                    email: [{ required: true, message: 'Email is required', trigger: 'blur' }],
                    password: [{ required: true, message: 'Password is required', trigger: 'blur' }],
                    role: [{ required: true, message: 'Role is required', trigger: 'blur' }],
                },
                downloadLoading: false
            }
        },
        created() {
            this.getList()
        },
        methods: {
            getList() {
                this.listLoading = true
                fetchListAccount(this.listQuery).then(response => {
                    this.list = response.data.items
                    this.listTotal = response.data.items
                    this.total = response.data.total
                    this.list = this.list.map(v => {
                        this.$set(v, 'edit', false);
                        v.originalRole = v.role;
                        return v;
                    });
                    setTimeout(() => {
                        this.listLoading = false
                    }, 1 * 1000)
                })
            },
            cancelEdit(row) {
                row.role = row.originalRole;
                row.edit = false;
                this.$message({
                    message: 'The Role has been restored to the original value',
                    type: 'warning',
                });
            },
            confirmEdit(row) {
                row.edit = false;
                row.originalRole = row.role;
                const data = {userId: row.id, role: row.role}
                changeRole(data)
                    .then(res => {
                        this.$message({
                            message: 'The Role has been edited',
                            type: 'success',
                        });
                    })
            },
            handleFilter() {
                this.list = this.listTotal
                if(this.listQuery.email) {
                    this.list = this.list.filter(account => account.email.toLowerCase().includes(this.listQuery.email.toLowerCase()))
                }
                if(this.listQuery.name) {
                    this.list = this.list.filter(account => account.name.toLowerCase().includes(this.listQuery.name.toLowerCase()))
                }
            },
            resetList(){
                this.list = this.listTotal
            },
            resetTemp() {
                this.temp = {
                    name: '',
                    email: '',
                    password: '',
                    role: undefined,
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
                        let checkName = this.list.filter(account => {
                            return account.name == this.temp.name
                        })
                        let checkEmail = this.list.filter(account => {
                            return account.email == this.temp.email
                        })
                        if(checkName.length > 0) {
                            this.$notify({
                                title: 'Notification',
                                message: 'This username already exists!',
                                type: 'warning',
                                duration: 2000
                            })
                            return
                        }
                        if(checkEmail.length > 0) {
                            this.$notify({
                                title: 'Notification',
                                message: 'This email already exists!',
                                type: 'warning',
                                duration: 2000
                            })
                            return
                        }
                        createAccount(this.temp).then(() => {
                            this.list.unshift(this.temp)
                            this.dialogFormVisible = false
                            this.getList()
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
            handleDownload() {
                this.downloadLoading = true
                    const tHeader = ['name', 'email', 'role', 'active' ,'created at', 'updated at']
                    const filterVal = ['name', 'email', 'role', 'activated', 'created_at', 'updated_at']
                    const data = this.formatJson(filterVal, this.list)
                    export_json_to_excel({
                        header: tHeader,
                        data,
                        filename: 'list-account'
                    })
                    this.downloadLoading = false
            },
            formatJson(filterVal, jsonData) {
                return jsonData.map(v => filterVal.map(j => {
                    if (j === 'activated') {
                        if(v[j]==1) return 'Yes';
                        return 'No'
                    } else if(j === 'role'){
                        if(v[j]==1) return 'User';
                        return 'Admin'
                    }
                    return v[j]
                }))
            },
            lockAccount(id, row) {
                console.log(id)
                const data = {idAccount: id}
                lockAccount(data)
                    .then(res => {
                        const index = this.list.indexOf(row)
                        this.list[index].activated = 0
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            unLockAccount(id, row) {
                const data = {idAccount: id}
                unlockAccount(data)
                    .then(res => {
                        const index = this.list.indexOf(row)
                        this.list[index].activated = 1
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            tableRowClassName({row, rowIndex}) {
                if (row.activated === 0) {
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
    .user {
        color: #00BF6F;
    }
    .admin {
        color: red;
    }
</style>
