<style lang="scss" src="style/textFeed.scss"></style>
<template lang="html" src="html/textFeed.html"></template>

<script>
import ContentContainer from "./content.vue";
import CommentContainer from "./comment.vue";
import {shareItem, getWhoLikes, updateSimpleUserList, getWhoViews, Comment} from "./../../../actions"
import {getStream} from "./../../../getters"

export default {
    vuex:{
        actions:{
            shareItem,
            getWhoLikes,
            getWhoViews,
            createComment: Comment.commentFeed,
            unshiftComment: Comment.unshiftComment,
            updateSimpleUserList,
            incrementNumberOfComment:Comment.incrementNumberOfComment
        },
        getters:{
            stream: getStream
        }
    },
    ready(){
        window.addEventListener('scroll', this.updateFeedViews);
        console.log(this.$el);
        var visible = this.checkVisible(this.$el);
        console.log(visible)

    },
    props: {
        feed: {
            type: Object,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            comment: "",
            comments: [],
            wantToCommentFeed: false,
            showCommentContainer: false,
            isViewUpdated:false
        }
    },
    computed: {
        showNumberOfComments(){
            return this.feed.numberOfComment > 0 ? this.feed.numberOfComment + " " : "";
        },
        backgroundColor(){
            var backgroundColor = this.feed.category.code == "lostAndFound" ? "#B1FFBB" : "white";
            return {
                backgroundColor
            };
        }
    },
    components: {
        ContentContainer,
        CommentContainer
    },
    methods: {
        updateFeedViews(){
            if(this.checkVisible(this.$el) && !this.isViewUpdated){
                this.isViewUpdated = !this.isViewUpdated;
                this.$http.post(
                    "/api/feeds/"+this.feed.id+"/views",
                    null,
                    this.setRequestHeaders()
                )
                    .then(response=>console.log(response))
            };
        },
        showWhoViews(){
            toastr.info('Loading List...');
            this.getWhoViews(this.feed.id)
        },
        toggleLikeButton(){
            var data = null,
                uri = "",
                headers = this.setRequestHeaders();
            console.log("toggle LIke")
            if (this.feed.likes.length == 0) {
                uri = this.getApi('likeFeed') + "/" + this.feed.id;
                this.$http.get(uri, data, headers).then(
                    ({data})=>{
                        this.feed.likes.push(data.like);
                        this.feed.numberOfLikes += 1
                    },
                    response=>conosle.log(response))
            } else {
                uri = this.getApi('unlikeFeed') + "/" + this.feed.id;
//                uri = this.getApi('unlikeFeed') + "/" + this.feed.likes[0].id;
                this.$http.get(uri, data, headers).then(
                    ({data})=>{
                        this.feed.likes = []
                        this.feed.numberOfLikes -= 1
                    },response=>conosle.log(response))
            }

        },
        deleteFeed () {
            this.$dispatch('deleteFeed', this.feed);
        },
        commentFeed(){
            if (this.comment.trim().length > 0)
                this.createComment(this.feed, this.comment).then(
                        ({data}) => {
                            this.incrementNumberOfComment(this.feed.id)
                            this.unshiftComment(this.feed.id, data.comment)
                            this.wantToCommentFeed = false
                        },
                        response => console.log(response)
                )
        },
        clickShowComment() {
            if (!this.showCommentContainer) {
                var uri = this.getApi("getFeedComments"),
                    headers = this.setRequestHeaders(),
                    data = {
                        feedId: this.feed.id
                    };
                this.$http.get(uri, data, headers).then(
                    function (response) {
                        this.comments = response.data.comments;
                    },
                    function (response) {
                        console.log(response);
                    })
            }
            this.showCommentContainer = !this.showCommentContainer;
        },
        clickComment(){
            this.wantToCommentFeed = !this.wantToCommentFeed;
        },
        showWhoLikes(){
            toastr.info('Loading List...');
            this.getWhoLikes(this.feed.id)
                .then(
                        ({data})=>{
                            console.log(data)
                            $("#simpleUserListModal").modal("show");
                            this.updateSimpleUserList(data);
                            toastr.clear()
                        },
                        response=>console.log(response)
                )
        },
        clickShare(){
            this.shareItem( this.feed.id, "feed")
            $("#shareWithOthers").modal("show");
        },
        updateComment(){
                this.comment = "";
                this.wantToCommentFeed = false
        }
    },
    filters: {
        parseDateToHuman (value) {
            return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
        }
    },
    events: {
//        updateComment(feedId, comment){
//            if (feedId == this.feed.id) {
//                this.comments.unshift(comment);
//                this.comment = "";
//                this.wantToCommentFeed = false
//            }
//            return true
//        },
        pushCommentsCollections (feedId, comments) {
            if (feedId == this.feed.id) this.comments = comments;
        },
        commentDeletedEvent(feedId, comment){
            if (feedId == this.feed.id)
                this.comments.$remove(comment);
            return true;
        }
    }
}
</script>