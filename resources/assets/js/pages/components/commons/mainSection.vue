<style>
    div.main-container div.standard.stream-container {
        margin-left: 210px;
    }

    @media (max-width: 767px) {
        div.main-container div.standard.stream-container {
            margin-left: 0px;
        }

        div.stream-container {
            margin-bottom: 90px;
        }
    }

</style>
<template>
    <div class="container-fluid">
        <div class="main-container container">
            <div class="standard left-side-menu col-sm-3 col-md-2 fixed hidden-xs">
                <ul class="list-group unstyled">
                    <li class="list-group-item" v-for="category in categoryList">
                        <a href="" v-link="{name:'category', params:{category:category.code}}">{{category.name}}</a>
                    </li>
                </ul>
            </div>
            <slot>
                This will only be displayed if there is no content
                to be distributed.
            </slot>
            <div class="standard right-side-menu hidden-sm hidden-xs col-md-3"></div>
        </div>

    </div>
</template>

<script>
    export default{
        props:{
            categoryList:{
                type:Array
            }
        }
    }
</script>