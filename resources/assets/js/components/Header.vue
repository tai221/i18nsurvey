<template>
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <a href="" class="navbar-brand">Home</a>
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navHeaderCollapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse navHeaderCollapse">
                <ul class="nav navbar-nav navbar-right text-center">
                    <li class="active"><a href="#">prvo</a></li>
                    <li calass="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Socijalno <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="">facebook</a></li>
                            <li><a href="">google+</a></li>
                            <li><a href="">instagram</a></li>
                        </ul>
                    </li>
                    <li><a href="#">trece</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header"
    }
</script>

<style scoped>
    body{
        background: #ededed;
    }
</style>