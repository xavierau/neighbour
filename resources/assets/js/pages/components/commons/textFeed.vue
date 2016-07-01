<style lang="scss" src="style/textFeed.scss"></style>
<template lang="html" src="html/textFeed.html"></template>

<script>
import ContentContainer from "./content.vue";
import CommentContainer from "./comment.vue";

export default {
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
            showCommentContainer: false
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
        toggleLikeButton(){
            var data = null,
                uri = "",
                headers = this.setRequestHeaders();
            if (this.feed.likes.length == 0) {
                uri = this.getApi('likeFeed') + "/" + this.feed.id;
                this.$http.get(uri, data, headers).then(
                    ({data})=>{
                        this.feed.likes.push(data.like);
                        this.feed.numberOfLikes += 1
                    },
                    response=>conosle.log(response))
            } else {
                uri = this.getApi('unlikeFeed') + "/" + this.feed.likes[0].id;
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
                this.$dispatch('commentFeed', this.feed, this.comment);
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
            this.$dispatch('getWhoLikeFeed', this.feed.id);
        }
    },
    filters: {
        parseDateToHuman (value) {
            return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
        }
    },
    events: {
        updateComment(feedId, comment){
            if (feedId == this.feed.id) {
                this.comments.unshift(comment);
                this.comment = "";
                this.wantToCommentFeed = false
            }
            return true
        },
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