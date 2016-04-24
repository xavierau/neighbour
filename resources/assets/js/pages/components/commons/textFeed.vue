<style></style>
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
            <content-container :content="feed.content"></content-container>
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
            <comment-container v-for="comment in comments" :comment="comment"></comment-container>
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
            commentFeed:function(){
              this.$dispatch('commentFeed',this.feed, this.comment);
            },
            clickShowComment: function () {
//                this.$dispatch('fetchComments', this.feed)
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
                            conole.log(response);
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
                console.log('get teh event');
                if (feedId == this.feed.id) this.comments = comments;
            }
        }
    }

</script>