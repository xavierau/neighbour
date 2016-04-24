<style>
    div.main.container{
        position: relative;
        top:80px;
    }

    div.left-side-menu {
        position: fixed;
        top:80px;
        min-height: 300px;
        background: rgba(255, 255, 255, 0.5);
    }

    div.left-side-menu li{
        padding-left: 0;
        padding-right: 0;
    }

    @media (max-width: 767px) {
        div.stream-container {
            margin-bottom: 90px;
        }
    }

</style>
<template>
    <div class="container main">
        <div class=" left-side-menu col-sm-2 col-md-1 fixed hidden-xs">
            <ul class="list-group unstyled">
                <li class="list-group-item">
                    <a href="" v-link="{name:'events'}">Events</a>
                </li>
                <li class="list-group-item" v-for="category in categoryList">
                    <a href="" v-link="{name:'category', params:{category:category.code}}">{{category.name}}</a>
                </li>
            </ul>
        </div>
        <slot>
            This will only be displayed if there is no content
            to be distributed.
        </slot>
    </div>
</template>

<script>
    export default{
        props: {
            categoryList: {
                type: Array
            }
        }
    }
</script>