<style>
    .clickDiv{
        border:dashed 2px #00b3ff;
        height: 100px;
    }
    .clickDiv i{
        display: block;
        color: #00b3ff;
        font-size: 2em;
        text-align: center;
        line-height: 100px;
    }
    .mobileImageContainer .img-controls.mobile{
        border: 1px solid black;
        height:20px;
        width:20px;
        border-radius: 10px;
        background-color: white;
        color: black;
        position: absolute;
        top:-5px;
        right:-5px;
    }
    .mobileImageContainer .img-controls.mobile i{
        display: block;
        line-height: 17px;
        text-align: center;
    }
    .mobileImageContainer{
        position:relative;
    }
</style>
<template>
    <!-- Modal -->
    <div class="modal fade" id="mobileImageUploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <textarea name="" id="" cols="30" rows="3"
                              class="form-control"
                              autofocus
                              placeholder="Comments for the photos"
                              v-model="content"
                              style="margin-bottom: 10px"
                    ></textarea>
                    <div class="row">
                        <input type="file" id="mobileUploadFileInput"
                               style="display: none;"
                               accept="image/*"
                               multiple
                               @change="inputFileChange"
                        >
                        <div v-show="photos.length>0" v-for="photo in photos" class="col-xs-4 col-sm-3">
                            <div class="mobileImageContainer">
                                <img :src="photo.url" alt="" class="img-responsive">
                                <div class="img-controls mobile">
                                    <i class="fa fa-times" aria-hidden="true" @click.prevent="removePhoto(photo)"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-3">
                            <div class="clickDiv" @click="showFileInput">
                                <i class="fa fa-plus"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click.prevent="clickUpdate">Update</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default{
        props:{
            content:{
                type:String,
                twoWay:true
            },
            photos:{
                type:Array
            }
        },
        methods:{
            showFileInput:function(){
                document.querySelector("input#mobileUploadFileInput").click();
            },
            inputFileChange: function(e) {
                var  self=this,
                        files = e.target.files;
                function readAndPreview(file){
                    var reader = new FileReader();
                    reader.addEventListener("load",function() {
                        self.$dispatch('newFile', file, this.result)
                    }, false);
                    reader.readAsDataURL(file)
                }
                if(files){
                    for(var key in files)
                        readAndPreview(files[key]);
                }
            },
            removePhoto: function(photo){
                this.$dispatch("removeTemUploadPhoto", photo)
            },
            clickUpdate: function () {
                console.log("this fired")
                this.$dispatch('updateFeed')
            }
        },
        events:{
            updateFeedCompleted: function () {
                $("#mobileImageUploadModal").modal('hide')
            }
        }
    }
</script>