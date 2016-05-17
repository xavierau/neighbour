<style>
    .comment-row {
        margin-bottom: 15px;
    }
</style>
<template>
    <div class=" comment-row">
        <img class="avatar pull-left" :src="comment.sender.avatar" alt="">
        <content-container
                class="comment-container"
                :sender="comment.sender.name"
                :sender-link="comment.avatarSrc"
                :content="comment.content"
        ></content-container>
        <ul class="list-inline">
            <li>
                <button class="unstyled"
                        @click.prevent="clickReplyComment"
                ><i class="fa fa-comment-o" aria-hidden="true"></i>
                    Reply
                </button>
            </li>
            <li v-show="comment.sender.id == user.id">
                <button class="unstyled"
                        @click.prevent="deleteComment"
                ><i class="fa fa-trash" aria-hidden="true"></i>
                    Delete
                </button>
            </li>
            <li v-show="comment.numberOfComment>0">
                <button class="unstyled"
                        @click.prevent="clickShowCommentReplay"
                >
                    {{comment.numberOfComment}} comments
                </button>
            </li>
        </ul>



        <div class="input-group" v-show="showReplyComment">
            <input type="text" class="form-control" v-model="replyCommentContent" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" @click.prevent="replyComment">Send!</button>
              </span>
        </div>
        <div class="comment" v-show="showCommentReply">
            <comment v-for="commentItem in comments" :user="user" :comment="commentItem"></comment>
        </div>
    </div>
</template>

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
            deleteComment() {
                this.$dispatch("deleteCommentEvent", this.comment)
            },
            clickReplyComment(){
                this.showReplyComment = true;
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
                if(feedId == this.comment.id)
                    this.comments.$remove(comment);
                return true;
            }
        }
    }
</script>