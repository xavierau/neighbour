<style lang="scss" src="style/eventFeed.scss"></style>
<template lang="html" src="html/eventFeed.html"></template>

<script>
    import ContentContainer from './content.vue';
    import {eventButtonsText} from "./../../../global/globalVariables.js"
    import {shareItem} from "./../../../actions"

    export default{
        vuex:{
            actions:{
                shareItem
            }
        },
        props:{
            feed:{
                type: Object
            }
        },
        data: function(){
            return {
                joinEvent: false,
                eventButtons: eventButtonsText
            }
        },
        computed:{
          getImage(){
              return this.feed.media.length>0? this.feed.media[this.feed.media.length-1].link:""
          }
        },
        filters: {
            parseDateToHuman: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").fromNow();
            },
            parseMonth: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").format("MMM");
            },
            parseDay: function (value) {
                return moment(value, "YYYY-MM-DD HH:mm:ss").format("D");
            },
            parseDefaultDateTimeFormat(value){
                return moment(value, "YYYY-MM-DD HH:mm:ss").format('MMMM Do YYYY, h:mm a');
            },
        },
        components:{
            ContentContainer
        },
        methods:{
            clickJoinEvent: function(){
                if(!this.feed.eventStatus != "yes")
                    this.$dispatch("joinEvent", this.feed)
            },
            clickJoinEventMaybe: function(){
                if(!this.feed.eventStatus != "maybe")
                    this.$dispatch("joinEventMaybe", this.feed)
            },
            clickJoinEventNo: function(){
                if(!this.feed.eventStatus != "no")
                    this.$dispatch("joinEventNo", this.feed)
            },
            clickShare(){
                this.shareItem( this.feed.id, "event")
                $("#shareWithOthers").modal("show");
            }
        },
        events:{
            jointedEvent: function (eventId) {
                if(this.feed.id == eventId){
                    toastr['success']('You just join the event');
                    this.feed.eventStatus = 'yes';
                }

            },
            jointedEventMaybe: function (eventId) {
                if(this.feed.id == eventId){
                    toastr['success']('You may join the event');
                    this.feed.eventStatus = 'maybe';
                }

            },
            jointedEventNo: function (eventId) {
                if(this.feed.id == eventId){
                    toastr['success']('You won\'t jon the event');
                    this.feed.eventStatus = 'no';
                }
            }
        }
    }
</script>