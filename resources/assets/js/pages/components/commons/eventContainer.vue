<style></style>
<template lang="html" src="html/eventContainer.html"></template>

<script>
    export default{
        props:{
            event:{
                type:Object
            }
        },
        computed:{
            getEventImage(){
                return this.event.media.length>0? this.event.media[0].link:"https://cdn1.iconfinder.com/data/icons/delivery-logistics/512/delivery_date-512.png"
            }
        },
        methods:{
            clickInvite(){
                this.$dispatch('inviteEvent', this.event)
            },
            clickEdit(){
                this.$router.go({name:'eventDetail', params:{eventId:this.event.id}})
            }
        }
    }
</script>