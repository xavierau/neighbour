/**
 * Created by Xavier on 16/5/2016.
 */
let Vue = require('vue');
let Resource = require('vue-resource');
let Chart = require('chart.js');


Vue.use(Resource);

Vue.config.debug = true;

import GraphMetric from "./graphMetric.js"

new Vue({
    el: "#dashboard-app"
})