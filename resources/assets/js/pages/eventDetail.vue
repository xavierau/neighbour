<style></style>
<template lant="html" src="html/eventDetail.html"></template>

<script>
    import UpdateEvent from './components/commons/updateEvent.vue';
    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi('getEvents') + "/" + this.$route.params.eventId,
                        headers = this.setRequestHeaders(),
                        data = null;
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        event: response.data.event,
                        numberOfParticipants: response.data.numberOfParticipants
                    })
                }, function (response) {
                    transition.abort('get no data')
                })
            }
        },
        components:{
            UpdateEvent
        },
        data: function () {
            return {
                event: {},
                numberOfParticipants:0
            }
        },
        methods:{
          showModal(){
              var target = $("#myModal");
              target.modal('show');
          },
            createNewEvent(data) {
                var uri = this.getApi("createEvent"),
                    headers = this.setRequestHeaders();
                this.$http.post(uri, data, headers).then(function (response) {
                    $("#myModal").modal('hide');
                    toastr.success("Event Created!");
                    this.$emit('eventCreated', response.data.event)
                }, function (response) {
                    console.log(response)
                });
                console.log("create new Event with newEvent Object store here")
            }
        },
        filters:{
            dateParser(date){
                console.log(date)
                if(date == "0000-00-00 00:00:00")
                    return ""
                return moment(date).format("LLL")
            }
        }
    }
</script>