/**
 * Created by Xavier on 16/5/2016.
 */
let Vue = require('vue');
let Vuex = require('vuex');
let Router = require('vue-router');
let Resource = require('vue-resource');

Vue.use(Vuex);
Vue.use(Router);
Vue.use(Resource);

Vue.config.debug=true;

let router = new Router({
    history: true
})

router.map({
    "/dashboard":{
        name:"dashboard",
        component: require('./components/dashboard')
    }
});

let App = Vue.extend({
    store:require('./vuex/store')
});

router.start(App, "body");