<style></style>
<template lang="html" src="html/mainFeedPage.html"></template>

<script>
    import {getUser, getStream} from "./../getters";
    import {getWhoViews, getWhoLikes, Stream} from "./../actions";
    import Feed from './components/feed.vue';
    import CreateEventModal from './components/commons/createEventModal.vue';
    import DesktopEditor from './components/desktopFeedEditor.vue';
    import MobileEditor from './components/commons/mobileEditor.vue';
    import ImageCarouselModal from './components/commons/imageCarouselModal.vue';
    import MobilePhotoUpload from './components/commons/mobilePhotoUplaod.vue';
    import ShareModal from './components/commons/shareModal.vue';

    import methods from "./methods/MainFeedPage";

    export default{
        vuex:{
            actions:{
                getWhoViews,
                getWhoLikes,
                updateStream: Stream.updateStream,
                unshiftStream: Stream.unshiftStream
            },
            getters:{
                user:getUser,
                stream: getStream
            }
        },
        route: {
            data: function (transition) {
                var uri = this.getApi("getPublicShownFeeds"),
                        headers = this.setRequestHeaders();
                this.$http.get(uri, "", headers).then(function ({data}) {
                    this.updateStream(data.items);
                    transition.next({
                        currentPage: data.currentPage,
                        previousPageUrl: data.previousPageUrl,
                        nextPageUrl: data.nextPageUrl,
                        hasMorePages: data.hasMorePages
                    })
                }, function () {
                    transition.abort("cannot fetch category list.");
                })
            }
        },
        ready(){
            this.updateGA("main");
            window.addEventListener('scroll', this.fetchNewFeedSet);
        },
        props: {
            categoryList: {
                type: Array
            },
        },
        data: function () {
            return {
                currentPage: "",
                previousPageUrl: "",
                nextPageUrl: "",
                hasMorePages: false,
                feed: {
                    category_id: 1,
                    content: "",
                    photos: []
                },
                calling:false,
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
                carouselImages: [],
                activeItemIndex: 0,
                simpleUserList:[],
                shareFeedId:"",
                shareFeedType:""
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
            MobilePhotoUpload,
            ShareModal
        },
        methods,
        events: {
            showMobilePhotoUpload: function () {
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
            joinEventMaybe: function (event) {
                this.joinEventMaybe(event)
            },
            joinEventNo: function (event) {
                this.joinEventNo(event)
            },
            showCreateEventModalEvent: function () {
                this.showModal();
            },
            createNewEvent: function (data) {
                this.createNewEvent(data);
            },
            updateFeed: function () {
                this.updateFeed();
            },
            fetchComments: function (feed) {
            },
            deleteFeed: function (feed) {
                this.deleteFeed(feed)
            },
            showLargerImage: function (images, selectedImageIndex) {
                this.showLargerImage(images, selectedImageIndex)
            },
            eventCreated(event){
//                this.unshiftStream(event)
                this.newEvent = {
                    name: "",
                    location: "",
                    startDateTime: "",
                    endDateTime: "",
                    description: "",
                    pic: "",
                    isPublic: 0
                }
            }
        }
    }
</script>