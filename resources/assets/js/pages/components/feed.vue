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
    <component :is="isEvent" :feed="feed" :user="user"></component>
</template>

<script>
    var moment = require('moment');
    import TextFeed from './commons/textFeed.vue';
    import EventFeed from './commons/eventFeed.vue';
    export default{
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
                comments: []
            }
        },
        computed: {
            isEvent: function () {
                return typeof this.feed.location != "undefined" ? "EventFeed" : "TextFeed";
            }
        },
        components: {
            TextFeed,
            EventFeed
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