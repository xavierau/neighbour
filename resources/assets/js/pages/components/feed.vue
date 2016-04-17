<style>
    div.feed-container {
        padding: 10px;
        background-color: white;
        margin-top: 10px;
        margin-bottom: 10px;
        color: black
    }

    div.feed-container img.avatar {
        height: 30px;
        width: 30px;
        border-radius: 15px;
        display: inline-block
    }

    div.feed-container hr {
        margin-top: 10px;
        margin-bottom: 5px;
    }

    div.feed-owner {
        margin-bottom: 5px;
    }

    div.feed-owner p.name {
        display: inline-block
    }

    div.actions ul {
        margin-bottom: 0;
    }

    button.unstyled {
        background: none;
        border: none;
    }
    button.unstyled:focus {
        outline: none;
    }

    div.feed-container div.comment {
        margin: -10px;
        margin-top: 15px;
        background-color: #dedede;
        padding: 20px;
    }

</style>
<template>
    <div class="feed-container">
        <div class="clearfix">
            <div class="feed-owner">
                <img class="avatar" :src="feed.avatarSrc" :alt="feed.sender">
                <p class="name">{{feed.sender}}</p>
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
    var moment = require('moment');
    import ContentContainer from './commons/content.vue';
    import CommentContainer from './commons/comment.vue';
    export default{
        props: {
            feed: {
                type: Object,
                required: true
            }
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