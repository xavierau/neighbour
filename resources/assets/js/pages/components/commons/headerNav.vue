<style></style>
<template>
    <div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" v-link="{name:home}">
                    Neighbour
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a id="profile" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <img :src="user.avatar" style="height:50px; width:50px; border-radius: 25px" alt="">
                            {{ user.name }}
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="profile">
                            <li><a v-link="{name:'profile'}">My Profile</a></li>
                            <li><a @click.prevent="logout">Logout</a></li>
                        </ul>
                    </li>


                    <li class="visible-xs"  v-for="category in categoryList">
                        <a href="" v-link="{name:'category', params:{category:category.code}}">{{category.name}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            user:{
                type:Object,
                required: true
            },
            categoryList:{
                type: Array
            }
        },
        methods: {
            logout: function () {
                this.$dispatch('logout');
            }
        }
    }
</script>