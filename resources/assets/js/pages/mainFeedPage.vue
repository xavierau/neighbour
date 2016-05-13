<style></style>
<template>
    <div>
        <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
            <desktop-editor
                    :content.sync="feed.content"
                    :category_id.sync="feed.category_id"
                    :category-list="categoryList"
                    :photos="feed.photos"
                    :firt-url="firstUrl"
                    :has-preview-url="hasPreviewUrl"
                    :url-preview="urlPreview"
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
        <image-carousel-modal
                :images="carouselImages"
                :active-item-index="activeItemIndex"
        ></image-carousel-modal>
        <mobile-photo-upload
            :content.sync="feed.content"
            :photos="feed.photos"
        ></mobile-photo-upload>
    </div>
</template>

<script>
    import Feed from './components/feed.vue';
    import CreateEventModal from './components/commons/createEventModal.vue';
    import DesktopEditor from './components/desktopFeedEditor.vue';
    import MobileEditor from './components/commons/mobileEditor.vue';
    import ImageCarouselModal from './components/commons/imageCarouselModal.vue';
    import MobilePhotoUpload from './components/commons/mobilePhotoUplaod.vue';

    import methods from "./methods/MainFeedPage";

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
            user: {
                type: Object
            }
        },
        data: function () {
            return {
                stream: [],
                feed: {
                    category_id: 1,
                    content: "",
                    photos: []
                },
                newEvent: {
                    name: "",
                    location: "",
                    startDateTime: "",
                    endDateTime: "",
                    description: "",
                    pic: "",
                    isPublic: 0
                },
                firstUrl: "",
                hasPreviewUrl: false,
                urlPreview: {
                    imageSrc: "",
                    url: "",
                    title: "",
                    description: ""
                },
                carouselImages:[],
                activeItemIndex:0
            }
        },
        watch: {
            "feed.content": function (value) {
                this.checkAndParseUrl(value)
            },
            firstUrl: function (value) {
                this.fetchUrlPreview(value)
            }
        },
        components: {
            Feed,
            CreateEventModal,
            DesktopEditor,
            MobileEditor,
            ImageCarouselModal,
            MobilePhotoUpload
        },
        methods,
        events: {
            showMobilePhotoUpload: function(){
                $("#mobileImageUploadModal").modal("show");
            },
            removeTemUploadPhoto: function (photo) {
                this.feed.photos.$remove(photo);
            },
            newFile: function (file, dataUrl) {
                console.log(file)
                this.feed.photos.push({file: file, url: dataUrl})
            },
            commentFeed: function (feed, comment) {
                this.newComment(feed, comment);
            },
            deleteCommentEvent: function (comment) {
                this.deleteComment(comment)
            },
            joinEvent: function (event) {
                this.joinEvent(event)
            },
            showCreateEventModalEvent: function () {
                this.showModal();
            },
            createNewEvent: function (data) {
                this.createNewEvent(data);
            },
            updateFeed: function () {
                console.log('event catch');
                this.updateFeed();
            },
            fetchComments: function (feed) {
            },
            deleteFeed: function (feed) {
                this.deleteFeed(feed)
            },
            showLargerImage: function(images, selectedImageIndex){
                this.showLargerImage(images, selectedImageIndex)
            }
        }
    }
</script>