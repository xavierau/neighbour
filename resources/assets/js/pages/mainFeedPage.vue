<style></style>
<template>
    <div>
        <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
            <desktop-editor
                    :content.sync="feed.content"
                    :category_id.sync="feed.category_id"
                    :category-list="categoryList"
            ></desktop-editor>
            <feed v-for="feed in stream"
                  :feed="feed"
                  :user="user"
            ></feed>

        </div>
        <create-event-modal
                :new-event.sync="newEvent"
        ></create-event-modal>
        <mobile-editor
                :content.sync="feed.content"
                :category_id.sync="feed.category_id"
                :category-list="categoryList"
        ></mobile-editor>
    </div>
</template>

<script>
    import Feed from './components/feed.vue';
    import CreateEventModal from './components/commons/createEventModal.vue';
    import DesktopEditor from './components/desktopFeedEditor.vue';
    import MobileEditor from './components/commons/mobileEditor.vue';

    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi("getPublicShownFeeds"),
                        headers = this.setRequestHeaders();
                this.$http.get(uri, "", headers).then(function (response) {
                    transition.next({
                        stream: response.data
                    })
                }, function () {
                    transition.abort("cannot fetch category list.");
                })
            }
        },
        props: {
            categoryList: {
                type: Array
            },
            user:{
                type:Object
            }
        },
        data: function () {
            return {
                stream: [],
                feed: {
                    category_id: 1,
                    content: ""
                },
                newEvent: {
                    name: "",
                    location: "",
                    startDateTime: "",
                    endDateTime: "",
                    description: "",
                    pic: "",
                    isPublic: 0
                }
            }
        },
        components: {
            Feed,
            CreateEventModal,
            DesktopEditor,
            MobileEditor
        },
        methods: {
            postCreated: function (response) {
                this.resetFeed();
                if (response.data.hasOwnProperty('feed'))
                    this.stream.unshift(response.data.feed);
                this.$broadcast('updateFeedCompleted')
            },
            unableToCreatePost: function (response) {
            },
            showModal: function () {
                var target = $("#myModal");
                target.modal('show');
            },
            resetFeed: function () {
                var defaultFeedObject = {
                    category_id: 1,
                    content: ""
                };
                this.$set('feed', defaultFeedObject);
            },
            deleteFeed: function(feed){
                var uri = this.getApi("feed")+"/"+feed.id,
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.delete(uri, data, headers).then(function (response) {
                    this.stream.$remove(feed);
                }.bind(this))
            },
            deleteComment: function(comment){
                var uri = this.getApi("feed")+"/"+comment.id,
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.delete(uri, data, headers).then(function (response) {
                    this.stream.map(function(feed){
                       if(feed.id == comment.reply_to)  feed.numberOfComment = feed.numberOfComment - 1
                    });
                    this.$broadcast("commentDeletedEvent", comment.reply_to,  comment);
                }.bind(this))
            },
            newComment: function(feed, comment){
                var uri = this.getApi("commentFeed"),
                        headers = this.setRequestHeaders(),
                        data = {
                            feedId: feed.id,
                            comment: comment
                        };
                this.$http.post(uri, data, headers).then(
                        function (response) {
                            this.stream.map(function(feed){
                                if(feed.id == response.data.comment.reply_to)  feed.numberOfComment = feed.numberOfComment + 1
                            });
                            this.$broadcast('updateComment', feed.id, response.data.comment)
                        },
                        function (response) {
                            conole.log(response);
                        })
            }
        },
        events: {
            commentFeed: function (feed, comment) {
                this.newComment(feed, comment);
            },
            deleteCommentEvent:function(comment){
                this.deleteComment(comment)
            },
            joinEvent: function (event) {
                var uri = this.getApi("joinEvent"),
                        headers = this.setRequestHeaders(),
                        data = {eventId: event.id};
                this.$http.post(uri, data, headers).then(
                        function (response) {
                            console.log(response);
                            this.$broadcast('jointedEvent', response.data.eventId)
                        },
                        function (response) {
                            conole.log(response);
                        })
            },
            showCreateEventModalEvent: function () {
                this.showModal();
            },
            createNewEvent: function (data) {
                var uri = this.getApi("createEvent"),
                        headers = this.setRequestHeaders();
                this.$http.post(uri, data, headers).then(function (response) {
                    $("#myModal").modal('hide');
                    toastr.success("Event Created!");
                    console.log(response)
                }, function (response) {
                    console.log(response)
                });
                console.log("create new Event with newEvent Object store here")
            },
            updateFeed: function () {
                if(this.feed.content.trim().length>0){
                    var uri = this.getApi("postFeed"),
                            headers = this.setRequestHeaders(),
                            data = this.feed;
                    this.$http.post(uri, data, headers).then(
                            this.postCreated,
                            this.unableToCreatePost
                    );
                }
            },
            fetchComments: function (feed) {
            },
            deleteFeed: function (feed) {
                this.deleteFeed(feed)
            }
        }
    }
</script>