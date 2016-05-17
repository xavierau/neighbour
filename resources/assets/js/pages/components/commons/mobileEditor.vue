<style>
    #mobileTextAreaInputGroupButton {
        vertical-align: bottom;
    }

    #mobileSendButton {
        border: none;
    }
</style>
<template>
    <div class="mobile-input visible-xs" id="mobileEditor">
        <div class="input-group" style="background-color: white">
            <span class="input-group-addon"
                  v-show="content.length==0"
                  @click="showMobilePhotoUpload">
            <i class="fa fa-camera" aria-hidden="true"></i>
        </span>
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
        ready: function () {
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
            showMobilePhotoUpload: function () {
                this.$dispatch("showMobilePhotoUpload")
            },
            showCreateEventModal: function () {
                this.$dispatch("showCreateEventModalEvent")
            },
            clickUpdate: function () {
                this.$dispatch('updateFeed')
            },
            resetTextAreaHeight: function () {
                $("#mobileTextArea").css("height", 34);
            }
        },
        events: {
            updateFeedCompleted: function () {
                this.resetTextAreaHeight();
                return true;
            }
        },
        ready(){
            var fixed_el = document.getElementById('mobileEditor'),
            input_el = document.querySelector('#mobileTextArea'),
            eleHeight = 68,
            bottom = 10,
            windowHeight = window.innerHeight,
            topOffset = 80,
            baseValue = windowHeight-topOffset-eleHeight-bottom;
            fixed_el.style.position = 'absolute';
            fixed_el.style.top =  baseValue+"px";

            updateHeight(){
                fixed_el.style.top = window.innerHeight -topOffset-eleHeight-bottom + window.scrollY+"px";
            }
            document.addEventListener('scroll',updateHeight);
            input_el.addEventListener('focus', ()=>{
                updateHeight();
                alert( window.innerHeight)
            });
            input_el.addEventListener('blur', updateHeight)
        }
    }
</script>