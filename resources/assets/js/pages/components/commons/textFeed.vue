<style lang="scss" src="style/textFeed.scss"></style>

<template>
    <div class="feed-container" :style="backgroundColor">
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
                </li>
                <li>
                    <button class="unstyled"
                            @click.prevent="toggleLikeButton"
                    ><i class="fa" :class="{
                    'like':feed.likes.length>0,
                    'fa-thumbs-up':feed.likes.length>0,
                    'fa-thumbs-o-up':feed.likes.length==0,
                    }" aria-hidden="true"></i>
                        Like
                    </button>
                </li>
                <li>
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
                <div class="input-group">
                    <textarea name="comment" id="comment" rows="1" class="form-control" v-model="comment"></textarea>
                    <span class="input-group-addon" @click="commentFeed">
                       Send
                    </span>
                </div>
        </div>
        <div class="comment" v-show="showCommentContainer && comments.length>0">
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
        data () {
            return {
                comment:"",
                comments: [],
                wantToCommentFeed:false,
                showCommentContainer:false
            }
        },
        computed:{
            showNumberOfComments(){
                return this.feed.numberOfComment>0? this.feed.numberOfComment+" ":"";
            },
            backgroundColor(){
                var backgroundColor = this.feed.category.code == "lostAndFound"? "#B1FFBB":"white";
                return {
                    backgroundColor
                };
            }
        },
        components:{
            ContentContainer,
            CommentContainer
        },
        methods: {
            toggleLikeButton(){
                var data=null,
                        headers=this.setRequestHeaders();
              if(this.feed.likes.length==0){
                  var uri = this.getApi('likeFeed')+"/"+this.feed.id;

                  this.$http.get(uri, data, headers).then(
                          ({data})=>this.feed.likes.push(data.like),
                          response=>conosle.log(response))
              }else{
                  var uri = this.getApi('unlikeFeed')+"/"+this.feed.likes[0].id;

                  this.$http.get(uri, data, headers).then(
                          ({data})=>this.feed.likes=[],
                          response=>conosle.log(response))
              }

            },
            deleteFeed () {
              this.$dispatch('deleteFeed', this.feed);
            },
            commentFeed(){
                if(this.comment.trim().length>0)
                    this.$dispatch('commentFeed',this.feed, this.comment);
            },
            clickShowComment() {
                if(!this.showCommentContainer){
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
            }
        },
        filters: {
            parseDateToHuman (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
            }
        },
        events: {
            updateComment(feedId, comment){
                if(feedId == this.feed.id){
                    this.comments.unshift(comment);
                    this.comment="";
                    this.wantToCommentFeed=false
                }
                return true
            },
            pushCommentsCollections (feedId, comments) {
                if (feedId == this.feed.id) this.comments = comments;
            },
            commentDeletedEvent(feedId, comment){
                if(feedId == this.feed.id)
                    this.comments.$remove(comment);
                return true;
            }
        }
    }

</script>