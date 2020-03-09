<template>
    <div class="content-wrapper">

    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                account: {
                    username: '',
                    password: ''
                },
                remember: false
            }
        },
        methods: {
            login() {
                event.preventDefault()
                const data = {
                    account: this.account,
                    remember: this.remember
                }
                this.$store.dispatch('retrieveToken', data)
                    .then((response) => {
                        this.$router.push({ name: 'manageaccount' })
                    })
            }
        }
    }
</script>

<style scoped>
    .content-wrapper {
        background-color: white !important;
    }


</style>
