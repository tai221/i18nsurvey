<template>
    <div>this is list survey</div>
</template>

<script>
    export default {
        name: "ListSurvey",
        created() {
            this.$store.dispatch('deleteSurveyId')
        }
    }

</script>

<style scoped>

</style>