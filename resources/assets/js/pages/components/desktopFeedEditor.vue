<style>
</style>
<template>
    <div class="hidden-xs ">
        <div class=" main-actions">
            <div class="col-xs-6 active">
                <p class="text-center">Feed</p>
            </div>
            <div class="col-xs-6">
                <p class="text-center" @click.prevent="showCreateEventModal">Create Event</p>
            </div>
        </div>
        <div class="clearfix inputContainer">
            <form action="" class="form">
                <div class="form-group clearfix">
                        <textarea
                                name="replay"
                                class="form-control"
                                id=""
                                cols="30"
                                rows="3"
                                v-model="content"
                        ></textarea>
                    <url-preview :url-preview="urlPreview" v-show="hasPreviewUrl"></url-preview>
                </div>
                <input
                        type="submit"
                        class="btn btn-default pull-right"
                        value="Update"
                        @click.prevent="clickUpdate">
                <div class="col-xs-3 pull-right">
                    <select name="type" class="form-control" v-model="category_id">
                        <option v-for="category in categoryList" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import UrlPreview from './commons/urlPrviewContainer.vue'
    export default{
        props: {
            content: {
                type: String,
                twoWay: true
            },
            category_id: {
                type: Number,
                twoWay: true
            },
            categoryList: {
                type: Array
            }
        },
        data: function () {
            return {
                firstUrl: "",
                hasPreviewUrl: false,
                urlPreview: {
                    imageSrc: "",
                    url: "",
                    title: "",
                    description: ""
                }
            }
        },
        components: {
            UrlPreview
        },
        watch: {
            content: function (value) {
                var textArray = value.split(" ");
                console.log('this is text array', textArray);
                var expression = /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/gi;
                textArray.map(function (item) {
                    if (item.match(expression)) this.firstUrl = item;
                }.bind(this));
            },
            firstUrl: function (value) {
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
            }
        },
        methods: {
            clickUpdate: function () {
                this.$dispatch('updateFeed')
            },
            showCreateEventModal: function () {
                this.$dispatch("showCreateEventModalEvent")
            }
        }
    }
</script>