/**
 * Created by Xavier on 14/8/2016.
 */
var Vue = require("vue");
var Vuex = require("vuex");

Vue.use(Vuex);

const state = {
  user     : user,
  userList : [],
  stream   : [],
  shareItem: {
    type: "",
    id  : 0
  }
};

const mutations = {
  UpdateUser (state, newUser) { state.user = newUser},
  UPDATEUSERLIST(state, newUserList){ state.userList = newUserList},
  UPDATESHAREITEM(state, newShareItem){ state.shareItem = newShareItem},
  UPDATESTREAM(state, newStream){ state.stream = newStream},
  UNSHIFTSTREAM(state, item){ state.stream.unshift(item)},
  UNSHIFTCOMMENT(state, itemId, comment){ state.stream.filter(item=>item.id == itemId)[0].comments.unshift(comment)},
  REMOVECOMMENT(state, itemId, commentId){
    var index = state.stream
         .filter(item=>item.id == itemId)[0].comments
                                            .indexOf(comment=>comment.id == commentId)
    if (index > -1) {
      state.stream
           .filter(item=>item.id == itemId)[0].comments.splice(index, 1);
    }
  },
  INCREMENTNUMBEROFCOMMENT(state, itemId){ state.stream.filter(item=>item.id == itemId)[0].numberOfComment++ },
  DECREMENTNUMBEROFCOMMENT(state, itemId){ state.stream.filter(item=>item.id == itemId)[0].numberOfComment-- },
};

export default new Vuex.Store({state, mutations})