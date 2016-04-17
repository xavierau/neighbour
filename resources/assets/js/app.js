"use strict";

var Vue = require('vue');
var Router = require('vue-router');
var Resource  = require('vue-resource');

Vue.use(Router);
Vue.use(Resource);

var router = new Router({
    history: true
});

Vue.config.debug = true;

router.map({
    '/app':{
        name:'home',
        component:require('./pages/app.vue')
    },
    '/events':{
        name:'events',
        component:require('./pages/events.vue')
    },
}).redirect({
    '*':"/"
});

var App = Vue.extend({
    created: function(){
        console.log('vue fired');
    }
});

router.start(App, '#app');