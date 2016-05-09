<style>
    #mobileTextAreaInputGroupButton{
        vertical-align: bottom;
    }
    #mobileSendButton{
        border:none;
    }
</style>
<template>
    <div class="mobile-input visible-xs">
        <div class="input-group" style="background-color: white">
             <textarea class="form-control"
                       rows="1"
                       id="mobileTextArea"
                       v-model="content"
             ></textarea>
      <span class="input-group-btn" id="mobileTextAreaInputGroupButton">
        <button class="btn btn-default"
                type="button"
                id="mobileSendButton"
                @click.prevent="clickUpdate"
        >Send!</button>
      </span>
        </div>

        <div class="btn-group btn-group-sm btn-group-justified">
            <div class="btn-group" role="group">
                <select name="type" class="form-control" v-model="category_id">
                    <option v-for="category in categoryList" :value="category.id">{{category.name}}</option>
                </select>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default" @click.prevent="showCreateEventModal">Create Event
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    var $ = require('jquery');
    require('jquery.autogrow-textarea');

    export default{
        ready:function () {
            $("#mobileTextArea").autogrow();
        },
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
        methods: {
            showCreateEventModal: function () {
                this.$dispatch("showCreateEventModalEvent")
            },
            clickUpdate: function () {
                this.$dispatch('updateFeed')
            },
            resetTextAreaHeight: function(){
                $("#mobileTextArea").css("height", 34);
            }
        },
        events:{
            updateFeedCompleted: function(){
                this.resetTextAreaHeight()
            }
        }
    }
</script>