/**
 * Created by Xavier on 11/5/2016.
 */
var methods = {
    postCreated: function (response) {
        toastr['success']("Update successfully!");
        this.resetFeed();
        if (response.data.hasOwnProperty('feed'))
            this.stream.unshift(response.data.feed);
        this.$broadcast('updateFeedCompleted');
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
            content: "",
            photos: []
        };
        this.$set('feed', defaultFeedObject);
        this.firstUrl = "";
        this.hasPreviewUrl = false;
        this.urlPreview = {
            imageSrc: "",
            url: "",
            title: "",
            description: ""
        };
    },
    deleteFeed: function (feed) {
        var uri = this.getApi("feed") + "/" + feed.id,
            data = null,
            headers = this.setRequestHeaders();
        this.$http.delete(uri, data, headers).then(function (response) {
            this.stream.$remove(feed);
        }.bind(this))
    },
    deleteComment: function (comment) {
        toastr['info']('deleting the comment');
        var uri = this.getApi("feed") + "/" + comment.id,
            data = null,
            headers = this.setRequestHeaders();
        this.$http.delete(uri, data, headers).then(function (response) {
            this.stream.map(function (feed) {
                if (feed.id == comment.reply_to)  feed.numberOfComment = feed.numberOfComment - 1
            });
            this.$broadcast("commentDeletedEvent", comment.reply_to, comment);
            toastr['success']('comment deleted');
        }.bind(this))
    },
    newComment (feed, comment) {
        var uri = this.getApi("commentFeed"),
            headers = this.setRequestHeaders(),
            data = {
                feedId: feed.id,
                comment: comment
            };
        this.$http.post(uri, data, headers).then(
            ({data}) =>{
                this.stream.map(feed => feed.numberOfComment = feed.id == data.comment.reply_to ? feed.numberOfComment = feed.numberOfComment + 1 : feed.numberOfComment);
                this.$broadcast('updateComment', feed.id, data.comment)
            },
            response => console.log(response)
        )
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
    joinEventMaybe: function (event) {
        var uri = this.getApi("joinEvent")+"?option=maybe",
            headers = this.setRequestHeaders(),
            data = {eventId: event.id};
        this.$http.post(uri, data, headers).then(
            function (response) {
                console.log(response);
                this.$broadcast('jointedEventMaybe', response.data.eventId)
            },
            function (response) {
                conole.log(response);
            })
    },
    joinEventNo: function (event) {
        var uri = this.getApi("joinEvent")+"?option=no",
            headers = this.setRequestHeaders(),
            data = {eventId: event.id};
        this.$http.post(uri, data, headers).then(
            function (response) {
                console.log(response);
                this.$broadcast('jointedEventNo', response.data.eventId)
            },
            function (response) {
                conole.log(response);
            })
    },
    createNewEvent: function (data) {
        var uri = this.getApi("createEvent"),
            headers = this.setRequestHeaders();
        toastr.info("Event Uploading!");
        this.$http.post(uri, data, headers).then(function (response) {
            $("#myModal").modal('hide');
            toastr.success("Event Created!");
            this.$emit('eventCreated', response.data.event)
        }, function (response) {
            toastr.warning(response);
            console.log(response)
        });
        console.log("create new Event with newEvent Object store here")
    },
    updateFeed() {
        console.log(this.feed.content);
        console.log(this.feed.photos);
        if (this.feed.content.trim().length > 0) {
            var formData = new FormData();
            formData.append('category_id', this.feed.category_id);
            formData.append('content', this.feed.content);
            if (this.feed.photos.length > 0)
                this.feed.photos.map(function (photo, index) {
                    formData.append('photo' + index, photo.file);
                });
            var uri = this.getApi("postFeed"),
                headers = this.setRequestHeaders(),
                data = formData;
            toastr['info']("Uploading...");
            this.$http.post(uri, data, headers).then(
                this.postCreated,
                this.unableToCreatePost
            );
        }
    },
    checkAndParseUrl: function (value) {
        var textArray = value.split(" ");
        console.log('this is text array', textArray);
        var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
        textArray.map(function (item) {
            if (item.match(expression)) this.firstUrl = item;
        }.bind(this));
    },
    fetchUrlPreview: function (value) {
        console.log('parse url');
        var data = {
            uri: value
        };
        this.$http.get("/api/urlPreview", data).then(function (response) {
            this.hasPreviewUrl = true;
            if (response.data.hasOwnProperty('og:image'))this.urlPreview.imageSrc = response.data['og:image'];
            if (response.data.hasOwnProperty('og:url'))this.urlPreview.url = response.data['og:url'];
            if (response.data.hasOwnProperty('og:title'))this.urlPreview.title = response.data['og:title'];
            if (response.data.hasOwnProperty('og:description'))this.urlPreview.description = response.data['og:description'];
        })

    },
    showLargerImage: function (images, selectedImageIndex) {
        this.$set("carouselImages", images);
        this.$set("activeItemIndex", selectedImageIndex);
        $('#imageCarouselModal').modal('show');
    }
};

export default methods