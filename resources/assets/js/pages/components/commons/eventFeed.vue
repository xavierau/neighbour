<style lang="scss" src="style/eventFeed.scss"></style>
<template lang="html" src="html/eventFeed.html"></template>

<script>
    import ContentContainer from './content.vue';
    export default{
        props:{
            feed:{
                type: Object
            }
        },
        data: function(){
            return {
                joinEvent: false
            }
        },
        computed:{
          getImage(){
              return this.feed.media.length>0? this.feed.media[0].link:""
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
            }
        },
        components:{
            ContentContainer
        },
        methods:{
            clickJoinEvent: function(){
                if(!this.joinEvent)
                    this.$dispatch("joinEvent", this.feed)
            }
        },
        events:{
            jointedEvent: function (eventId) {
                if(this.feed.id == eventId)
                        this.joinEvent = true;
            }
        }
    }
</script>