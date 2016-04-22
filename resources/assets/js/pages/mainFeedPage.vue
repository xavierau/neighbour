<style></style>
<template>
    <div>
        <div class="standard stream-container col-sm-8 col-md-7">
            <desktop-editor
                    :content.sync="feed.content"
                    :category_id.sync="feed.category_id"
                    :category-list="categoryList"
            ></desktop-editor>
            <feed v-for="feed in stream"
                  :feed="feed"></feed>

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
                },function () {
                    transition.abort("cannot fetch category list.");
                })
            }
        },
        props: {
            categoryList: {
                type: Array
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
            }
        },
        events: {
            showCreateEventModalEvent:function(){
                this.showModal();
            },
            createNewEvent: function (data) {
                var uri = this.getApi("createEvent"),
                        headers = this.setRequestHeaders();
                this.$http.post(uri, data, headers).then(function(response){
                    $("#myModal").modal('hide');
                    toastr.success("Event Created!");
                    console.log(response)
                }, function(response){
                   console.log(response)
                });
                console.log("create new Event with newEvent Object store here")
            },
            updateFeed: function () {
                    var uri = this.getApi("postFeed"),
                            headers = this.setRequestHeaders(),
                            data = this.feed;
                    this.$http.post(uri, data, headers).then(
                            this.postCreated,
                            this.unableToCreatePost
                    );
            },
            fetchComments: function (feedId) {
                var result = this.comments.filter(function (commentCollection) {
                    if (commentCollection.feedId == feedId) return commentCollection.comments
                })[0];
                this.$broadcast('pushCommentsCollections', feedId, result.comments);
            }
        }
    }
</script>