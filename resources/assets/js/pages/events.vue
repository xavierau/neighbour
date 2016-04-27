<style>
    .eventContainer {
        border: 1px solid grey;
    }

    .row .eventContainer:first-child {
        margin-left: 15px
    }
</style>
<template>
    <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
        <h2>My Events</h2>
        <div class="row">
            <event-container v-for="event in myEvents" :event="event"></event-container>
        </div>

        <h2>Public Events</h2>
        <div class="row">
            <div v-for="event in publicEvents" class="col-xs-6 col-sm-4 col-md-3">
                <h4>{{event.name}}</h4>
                <p>{{event.description}}</p>
            </div>
        </div>

    </div>
</template>

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