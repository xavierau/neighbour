<style>
</style>
<template>
    <div class="feed-container">
        <div class="clearfix">
            <div class="feed-owner">
                <img class="avatar" :src="feed.sender.avatar" :alt="feed.sender">
                <p class="name">{{feed.sender.name}}</p>
                <p class="time">
                    <small>{{feed.created_at | parseDateToHuman}}</small>
                </p>
            </div>
            <content-container :content="feed.content" :media="feed.media"></content-container>
            <button
                    class="pull-right unstyled"
                    v-show="feed.numberOfComment>0"
                    @click.prevent="clickShowComment">{{feed.numberOfComment}} comments
            </button>
        </div>
        <hr>
        <div class="actions">
            <ul class="list-inline">
                <li>
                    <button class="unstyled" @click.prevent="clickComment"><i class="fa fa-comment-o" aria-hidden="true"></i>
                        Comment
                    </button>
                </li>
                <li>
                    <button class="unstyled"><i class="fa fa-share-alt" aria-hidden="true"></i>
                        Share
                    </button>
                    <button class="unstyled"
                            @click.prevent="deleteFeed"
                            v-show="feed.sender.id == user.id"
                    ><i class="fa fa-trash" aria-hidden="true"></i>
                        Delete
                    </button>
                </li>
            </ul>
        </div>
        <div v-show="wantToCommentFeed">
            <form @submit.prevent="commentFeed">
                <textarea name="comment" id="comment" rows="1" class="form-control" v-model="comment"></textarea>
                <button class="btn default btn-block btn-xs">Comment</button>
            </form>
        </div>
        <div class="comment" v-show="comments.length>0">
            <comment-container v-for="comment in comments" :user="user" :comment="comment"></comment-container>
        </div>
    </div>
</template>

<script>

    import ContentContainer from './content.vue';
    import CommentContainer from './comment.vue';

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
        data: function () {
            return {
                comment:"",
                comments: [],
                wantToCommentFeed:false
            }
        },
        computed:{
            showNumberOfComments: function(){
                return this.feed.numberOfComment>0? this.feed.numberOfComment+" ":"";
            }
        },
        components:{
            ContentContainer,
            CommentContainer
        },
        methods: {
            deleteFeed: function () {
              this.$dispatch('deleteFeed', this.feed);
            },
            commentFeed:function(){
                if(this.comment.trim().length>0)
                    this.$dispatch('commentFeed',this.feed, this.comment);
            },
            clickShowComment: function () {
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
            },
            clickComment: function(){
                this.wantToCommentFeed = true;
            }
        },
        filters: {
            parseDateToHuman: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
            }
        },
        events: {
            updateComment:function(feedId, comment){
                if(feedId == this.feed.id){
                    this.comments.unshift(comment);
                    this.comment="";
                }
            },
            pushCommentsCollections: function (feedId, comments) {
                if (feedId == this.feed.id) this.comments = comments;
            },
            commentDeletedEvent: function(feedId, comment){
                if(feedId == this.feed.id)
                    this.comments.$remove(comment);
            }
        }
    }

</script>