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
            "/profile":{
                name: 'profile',
                component: require('./pages/userProfile.vue')
            },
            "/events":{
                name: 'profile',
                component: require('./pages/events.vue')
            },
            "/events/:eventId":{
                name: 'profile',
                component: require('./pages/userProfile.vue')
            },
            "/:category":{
                name: 'category',
                component: require('./pages/events.vue')
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
            console.log("catch logout event");
            window.location.replace('/logout');
        },
        updateUser:function(newUser){
            this.$set('user', newUser);
            this.$broadcast("userHasBeenUpdated", newUser);
        }
    }
});

router.start(App, '#app');