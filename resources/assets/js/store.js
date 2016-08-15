/**
 * Created by Xavier on 14/8/2016.
 */
var Vue = require("vue");
var Vuex = require("vuex");

Vue.use(Vuex);

const state = {
    user: user
};

const mutations = {
    UpdateUser (state, newUser) {
        console.log("from store");
        
        state.user = newUser
    }
};

export default new Vuex.Store({state, mutations})