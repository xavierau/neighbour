<style>
    ul.nav li.default {
        margin-top: 13px;
    }

    ul.notifications {
        max-height: 200px;
        overflow-y: scroll;
    }
</style>
<template>
    <div class="navbar navbar-inverse navbar-fixed-top scroll-me" id="menu-section">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" v-link="{name:'home'}">
                    Neighbour
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="default">
                        <a v-link="{name:'conversation'}">Direct Message</a>
                    </li>
                    <li class="default">
                        <a id="notifications" data-target="#" href="" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false"
                           @click="getNotifications">
                            Notifications
                            <span class="badge" v-show="user.has_notification">New</span>
                        </a>

                        <notifications
                                my-class="dropdown-menu notifications"
                                aria-labelledby="notifications"
                                :notifications="notifications"
                        ></notifications>
                    </li>
                    <li>
                        <a id="profile" data-target="#" href="" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            <img :src="user.avatar" style="height:50px; width:50px; border-radius: 25px" alt="">
                            {{ user.name }}
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="profile">
                            <li><a v-link="{name:'profile'}">My Profile</a></li>
                            <li><a @click.prevent="logout">Logout</a></li>
                        </ul>
                    </li>

                    <li class="visible-xs">
                        <a href="" v-link="{name:'events'}">Events</a>
                    </li>
                    <li class="visible-xs" v-for="category in categoryList">
                        <a href="" v-link="{name:'category', params:{category:category.code}}">{{category.name}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    var socket;
    import Notifications from './notification.vue';
    export default{
        created: function () {
            socket = require('socket.io-client')(":3000");
        },
        beforeDestroy: function () {
            socket.disconnect();
        },
        ready: function () {
            var channel = "neighbourApp:notification:newNotification_" + this.user.id;
            console.log(channel);
            socket.on(channel, function (data) {
                console.log(data);
                this.user.notificationsCount = data;
                this.user.has_notification = true;
            }.bind(this))
        },
        props: {
            user: {
                type: Object,
                required: true
            },
            categoryList: {
                type: Array
            },
            notifications: {
                type: Array
            }
        },
        components: {
            Notifications
        },
        methods: {
            getNotifications: function () {
                if (this.user.has_notification) {
                    var uri = this.getApi("notifications"),
                            data = null,
                            headers = this.setRequestHeaders();
                    this.$http.get(uri, data, headers).then(function (response) {
                        return this.$set('notifications', response.data.notifications);
                    }.bind(this));


                    uri = this.getApi("acknowledgedNotifications"),
                            data = null,
                            headers = this.setRequestHeaders();
                    this.$http.get(uri, data, headers);

                    this.user.has_notification = false;
                }

            },
            logout: function () {
                this.$dispatch('logout');
            }
        }
    }
</script>