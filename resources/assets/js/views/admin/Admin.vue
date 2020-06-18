<template>
    <div>
        <HeaderAdmin></HeaderAdmin>
        <router-view></router-view>
    </div>
</template>

<script>
    import HeaderAdmin from "./HeaderAdmin";
    export default {
        name: "admin",
        components:{
            HeaderAdmin,
        },
    }
</script>

<style scoped>

</style>