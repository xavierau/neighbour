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

import globalMixin from './global/mixin.js'
import store from './store'
import {getUser} from './getters'

Vue.mixin( globalMixin);

router.map({
    '/app': {
        component: require('./pages/app.vue'),
        subRoutes:{
            "/":{
                name: 'home',
            component: require('./pages/mainFeedPage.vue')
            },
            "/search":{
                name: 'search',
                component: require('./pages/search.vue')
            },
            "/feed/:feedId":{
                name: 'feed',
                component: require('./pages/singleFeed.vue')
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
            },
        }
    }
}).redirect({
    '*': "/"
}).afterEach(function () {
    $('.collapse.in').collapse('hide');
});

var App = Vue.extend({
    store: store,
    vuex:{
        getters:{
            user: getUser
        }
    },
    ready(){
      this.setGAUserID(this.user.id)
    }
});

router.start(App, '#app');