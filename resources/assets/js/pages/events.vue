<style lang="scss" src="style/events.scss"></style>
<template lang="html" src="html/events.html"></template>

<script>
    import EventContainer from './components/commons/eventContainer.vue'
    export default {
        route: {
            data: function (transition) {
                var uri = this.getApi("getEvents"),
                        headers = this.setRequestHeaders(),
                        data = null;
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        myEvents: response.data.myEvents,
                        publicEvents: response.data.publicEvents
                    })
                }, function (response) {
                    transition.abort('cannot load data')
                })
            }
        },
        components:{
            EventContainer
        },
        data: function () {
            return {
                myEvents: [],
                publicEvents: []
            }
        }
    }
</script>