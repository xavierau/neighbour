/**
 * Created by Xavier on 16/5/2016.
 */

let Vue = require("vue");
let Vuex = require("vuex");

Vue.use(Vuex);

const state={
    metrics:[],
    shownMetrics:[],
    count:0,
    feeds:[]
};

const mutations={
    INCREMENT(state){
        state.count++
    },
    UPDATEMETRICS(state, metrics){
        state.metrics = metrics
    },
    UPDATESHOWNMETRICS(state, metrics){
        state.shownMetrics = metrics
    }
};

module.exports = new Vuex.Store({state, mutations});