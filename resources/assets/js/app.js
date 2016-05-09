"use strict";

var Vue = require('vue');
var Router = require('vue-router');
var Resource = require('vue-resource');
Vue.use(Router);
Vue.use(Resource);

window.toastr = require('toastr');
window.moment = require('moment');



var router = new Router({
    history: true
});

Vue.config.debug = true;

Vue.mixin({
    methods: {
        everyPairIsTrue:function(object){
            var check = true;
            for(var key in object){
                if(object[key] == false) {
                    check = false;
                    break
                }
            }
            return check;
        },
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
                case "acknowledgedNotifications":
                    uri = uri + "notifications/acknowledge"
                    break;
                case "notifications":
                    uri = uri + "notifications"
                    break;
                case "feed":
                    uri = uri + "feed"
                    break;
                case "postFeed":
                    uri = uri + "feed"
                    break;
                case "categoryList":
                    uri = uri + "categoryList"
                    break;
                case "selectCategoryList":
                    uri = uri + "selectCategoryList"
                    break;
                case "getFeeds":
                    uri = uri + "feeds"
                    break;
                case "getPublicShownFeeds":
                    uri = uri + "feeds/showPublic"
;                case "frontPage":
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
                case "deleteComment":
                    uri = uri + "feeds/feedId/comments/commentId"
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
            "/public":{
                component: require('./pages/mainFeedPage.vue')
            },
            "/:category":{
                name: 'category',
                component: require('./pages/categories.vue')
            }
        }
    }
}).redirect({
    '*': "/"
}).afterEach(function () {
    $('.collapse.in').collapse('hide');
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