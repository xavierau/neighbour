<style lang="scss" src="style/feed.scss">
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