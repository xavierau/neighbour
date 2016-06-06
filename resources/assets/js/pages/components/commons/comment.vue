<style>
    .comment-row {
        margin-bottom: 15px;
    }
</style>
<template lang="html" src="html/comment.html"></template>

<script>
    import ContentContainer from "./content.vue"
    export default{
        name: "comment",
        props: {
            comment: {
                type: Object,
                required: true
            },
            user: {
                type: Object
            }
        },
        data(){
            return {
                replyCommentContent: "",
                comments: [],
                showReplyComment: false,
                showCommentReply: false
            }
        },
        components: {
            ContentContainer
        },
        methods: {
            toggleLikeButton(){
                var data=null,
                        headers=this.setRequestHeaders();
                if(this.comment.likes.length==0){
                    var uri = this.getApi('likeFeed')+"/"+this.comment.id;

                    this.$http.get(uri, data, headers).then(
                            ({data})=>{
                                this.comment.likes.push(data.like);
                                this.comment.numberOfLikes += 1;
                            },
                            response=>conosle.log(response))
                }else{
                    var uri = this.getApi('unlikeFeed')+"/"+this.comment.likes[0].id;

                    this.$http.get(uri, data, headers).then(
                            ({data})=>{
                                this.comment.likes=[];
                                this.comment.numberOfLikes -= 1;
                            },
                            response=>conosle.log(response))
                }

            },
            deleteComment() {
                this.$dispatch("deleteCommentEvent", this.comment)
            },
            clickReplyComment(){
                this.showReplyComment = !this.showReplyComment;
                console.log('reply comment')
            },
            replyComment(){
                this.$dispatch("commentFeed", this.comment, this.replyCommentContent)
            },
            clickShowCommentReplay(){
                if(!this.showCommentReply){
                    var uri = this.getApi("getFeedComments"),
                            headers = this.setRequestHeaders(),
                            data = {
                                feedId: this.comment.id
                            };
                    this.$http.get(uri, data, headers).then(
                            function (response) {
                                this.comments = response.data.comments;
                                this.showCommentReply = true;
                            },
                            function (response) {
                                console.log(response);
                            })
                }
                this.showCommentReply = !this.showCommentReply;
            }
        },
        events: {
            updateComment(commentId, replay){
                if (commentId == this.comment.id){
                    this.replyCommentContent = "";
                    this.showReplyComment= false;
                    this.comment.numberOfComment++;
                }
                return true
            },
            commentDeletedEvent(feedId, comment){
                if(feedId == this.comment.id){
                    this.comments.$remove(comment);
                    this.comment.numberOfComment--
                }

                return true;
            }
        }
    }
</script>