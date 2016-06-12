export default {
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
                case "likeFeed":
                    uri = uri + "like/Feed"
                    break;
                case "getMarqueeContent":
                    uri = uri + "marquee"
                    break;
                case "unlikeFeed":
                    uri = uri + "unlike/Feed"
                    break;
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
}