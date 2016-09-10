/**
 * Created by Xavier on 14/8/2016.
 */
var Vue = require("vue")
var Resource = require("vue-resource")
Vue.use(Resource);

const Api = {
  createEvent: "/api/events"
}


export const Stream = {
  updateStream({dispatch}, stream){ dispatch("UPDATESTREAM", stream)},
  unshiftStream({dispatch}, item){ dispatch("UNSHIFTSTREAM", item)},
}

export const Comment = {
  commentFeed(store, feed, comment) {
    console.log("from acionts")
    console.log(feed)
    var uri     = "/api/feeds/comment?feedId=" + feed.id,
        headers = {
          headers: {
            "X-CSRF-TOKEN": document.querySelector("meta[name='csrf_token']").getAttribute('content')
          }
        }
    var data = {
      feedId : feed.id,
      comment: comment
    };
    return Vue.http.post(uri, data, headers)
  },
  unshiftComment({dispatch}, itemId, comment){dispatch("UNSHIFTCOMMENT", itemId, comment)},
  incrementNumberOfComment({dispatch}, itemId){ dispatch("INCREMENTNUMBEROFCOMMENT", itemId) },
  decrementNumberOfComment({dispatch}, itemId){ dispatch("DECREMENTNUMBEROFCOMMENT", itemId) },
}

export const updateUser = ({dispatch}, user) => dispatch("UpdateUser", user)

export const getWhoViews = ({dispatch}, feedId) => {
  Vue.http.get('/api/feeds/' + feedId + '/whoViews').then(
    ({data})=> {
      $("#simpleUserListModal").modal("show");
      dispatch("UPDATEUSERLIST", data)
      toastr.clear()
    },
    response=>console.log(response))
}
export const getWhoLikes = (store, feedId) => {
  Vue.http.get('/api/feed/' + feedId + '/whoLikes').then(
    ({data})=> {
      $("#simpleUserListModal").modal("show");
      dispatch("UPDATEUSERLIST", data)
      toastr.clear()
    },
    response=>console.log(response))
}
export const updateSimpleUserList = ({dispatch}, newUserList) => dispatch("UPDATEUSERLIST", newUserList)

export const shareItem = ({dispatch}, feedId, type) => {
  var item = {
    type: type,
    id  : feedId
  }
  dispatch("UPDATESHAREITEM", item)
  $("#shareWithOthers").modal("show");
}

export const appendSearchResult = ({dispatch}, newResult) => {dispatch("APPENDTOSEARCHRESULT", newResult)}
export const resetSearchResult = ({dispatch})=> {dispatch("RESETSEARCHRESULT")}

export const logout = () => window.location.replace('/logout')
