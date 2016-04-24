"use strict";

var Vue = require('vue');
var Router = require('vue-router');
var Resource = require('vue-resource');
window.toastr = require('toastr');
window.moment = require('moment');
Vue.use(Router);
Vue.use(Resource);

var router = new Router({
    history: true
});

Vue.config.debug = true;

Vue.mixin({
    methods: {
        setRequestHeaders:function(){
            return {
                headers:{
                    "X-CSRF-TOKEN":document.querySelector("meta[name='csrf_token']").getAttribute('content')
                }
            }
        },
        getApi: function (apiName) {
            var uri = "/api/";
            switch (apiName) {
                case "postFeed":
                    uri = uri + "feed"
                    break;
                case "categoryList":
                    uri = uri + "categoryList"
                    break;
                case "getFeeds":
                    uri = uri + "feeds"
                    break;
                case "getPublicShownFeeds":
                    uri = uri + "feeds/showPublic"
                    break;
                case "frontPage":
                    uri = uri + "frontPage"
                    break;
                case "userProfile":
                    uri = uri + "profile"
                    break;
                case "createEvent":
                    uri = uri + "events"
                    break;
                case "joinEvent":
                    uri = uri + "joinEvent"
                    break;
                case "getEvents":
                    uri = uri + "events"
                    break;
                case "allConversation":
                    uri = uri + "conversations"
                    break;
                case "getTheConversation":
                    uri = uri + "conversation"
                    break;
                case "conversationMessages":
                    uri = uri + "conversations/messages"
                    break;
                case "searchUserByUserName":
                    uri = uri + "users/search/username"
                    break;
                case "commentFeed":
                    uri = uri + "feeds/comment"
                    break;
                case "getFeedComments":
                    uri = uri + "feeds/comments"
                    break;
            }
            return uri;
        }
    }
});

router.map({
    '/app': {
        component: require('./pages/app.vue'),

        subRoutes:{
            "/":{
                name: 'home',
                component: require('./pages/mainFeedPage.vue')
            },
            "/inbox":{
                name: 'conversation',
                component: require('./pages/conversation.vue')
            },
            "/inbox/:conversationId/messages":{
                name: 'messages',
                component: require('./pages/messages.vue')
            },
            "/profile":{
                name: 'profile',
                component: require('./pages/userProfile.vue')
            },
            "/events":{
                name: 'events',
                component: require('./pages/events.vue')
            },
            "/events/:eventId":{
                name: 'eventDetail',
                component: require('./pages/eventDetail.vue')
            },
            "/:category":{
                name: 'category',
                component: require('./pages/categories.vue')
            }
        }
    }
}).redirect({
    '*': "/"
});

var App = Vue.extend({
    data: function () {
        return {
            user: user
        }
    },
    events: {
        logout: function () {
            window.location.replace('/logout');
        },
        updateUser:function(newUser){
            this.$set('user', newUser);
            this.$broadcast("userHasBeenUpdated", newUser);
        }
    }
});

router.start(App, '#app');