<style>
    .img-container div{
        margin-bottom: 15px;
    }
    .img-container .img-controls{
        display: none;
        position: absolute;
        font-size: 2em;
        text-shadow: 2px 2px black;
    }
    .img-container div:hover .img-controls{
        display: block;
    }
    .img-controls.fa-times{
        color:rgba(255,255,255,0.7);
        top:10px;
        right:30px
    }
    .img-controls.fa-times:hover{
        color:rgb(255,255,255);
    }

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
                    <div class="img-container row" v-show="photos.length>0">
                        <input type="file" style="display: none" name="file1" id="file1" @change="inputFileChange" accept="image/*" multiple>
                        <div class="col-xs-6 col-sm-3" v-for="photo in photos">
                            <img :src="photo.url" alt="" class="img-responsive">
                            <i class="fa img-controls fa-times" aria-hidden="true" @click.prevent="removePhoto(photo)"></i>
                        </div>
                    </div>
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
                <button class="btn btn-default" @click.prevent="showFileInput">Add Photo</button>
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
            },
            photos:{
                type:Array
            },
            firstUrl:{
                type:String
            },
            hasPreviewUrl:{
                type:Boolean
            },
            urlPreview:{
                type:Object
            }
        },
        components: {
            UrlPreview
        },
        methods: {
            removePhoto: function(photo){
                this.$dispatch("removeTemUploadPhoto", photo)
            },
            showFileInput: function () {
              document.querySelector("input[type='file']").click()
            },
            inputFileChange: function (e) {
                var  self = this,
                    files = e.target.files;
                function readAndPreview(file){
                    var reader = new FileReader();
                    reader.addEventListener("load", function () {
                        self.$dispatch('newFile', file, this.result)
                    }, false);
                    reader.readAsDataURL(file)
                }
                if(files){
                    for(var key in files)
                        readAndPreview(files[key]);
                }
            },
            clickUpdate: function () {
                this.$dispatch('updateFeed')
            },
            showCreateEventModal: function () {
                this.$dispatch("showCreateEventModalEvent")
            }
        }
    }
</script>