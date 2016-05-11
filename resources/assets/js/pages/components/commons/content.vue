<style>
    div.comment-container{
        margin-left: 50px;
    }
    button.showMoreButton{
        color: #3dbce9;
    }

    .feed-img-container img{
        max-height:394px;
        margin-bottom:15px;
    }
</style>
<template>
    <div :class="class">
        <a :href="senderLink" v-show="sender">{{sender}}</a>
        <div v-html="content | summarize | marked"></div>
        <div class="feed-img-container" :class="{'first':$index==0,'more':$index>0}" v-for="photo in media">
            <div :class="{'col-sm-12':$index==0,'col-sm-4':$index>0}">
                <img :src="photo.link" alt="" class="img-responsive" @click.prevent="showLargerImage($index)">
            </div>
        </div>
        <button v-show="showButton" class="showMoreButton unstyled" @click.prevent="showAll=true">...more
        </button>
    </div>
</template>
<script>
    var marked = require('marked');
    export default{
        props:{
            sender:{
                type: String,
                default:""
            },
            senderLink:{
                type: String,
                default:""
            },
            content:{
                type: String,
                required: true
            },
            media:{
              type:Array
            },
            maxChar:{
                type:Number,
                default: 250
            },
            class:{
                type:String
            }
        },
        data:function(){
            return {
                showAll:false
            }
        },
        computed:{
            showButton: function () {
                return this.content.length>this.maxChar && !this.showAll
            },
            calculateContent: function () {
                if (this.content.length > this.maxChar && !this.showAll) {
                    return this.content.substr(0, this.maxChar);
                }
                return this.content;
            }
        },
        filters:{
            summarize: function(content){
                if (content.length > this.maxChar && !this.showAll) {
                    return content.substr(0, this.maxChar);
                }
                return content;
            },
            marked: marked
        },
        methods:{
            showLargerImage:function(index){
                this.$dispatch("showLargerImage", this.media, index)
            }
        }
    }
</script>