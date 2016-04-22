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
                    v-show="feed.numberOfComments>0"
                    @click.prevent="clickShowComment">{{feed.numberOfComments}} comments
            </button>
        </div>
        <hr>
        <div class="actions">
            <ul class="list-inline">
                <li>
                    <button class="unstyled"><i class="fa fa-comment-o" aria-hidden="true"></i>
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
                comments: []
            }
        },
        components:{
            ContentContainer,
            CommentContainer
        },
        methods: {
            clickShowComment: function () {
                this.$dispatch('fetchComments', this.feed.id)
            }
        },
        filters: {
            parseDateToHuman: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
            }
        },
        events: {
            pushCommentsCollections: function (feedId, comments) {
                if (feedId == this.feed.id) this.comments = comments;
            }
        }
    }

</script>