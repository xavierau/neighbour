<style>
    div.comment-container{
        margin-left: 50px;
    }
    button.showMoreButton{
        color: #3dbce9;
    }
</style>
<template>
    <div :class="class">
        <a :href="senderLink" v-show="sender">{{sender}}</a>
        <div v-html="content | summarize | marked"></div>
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
        }

    }
</script>