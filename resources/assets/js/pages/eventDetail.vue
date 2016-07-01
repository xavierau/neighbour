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
                this.$http.get(uri, data, headers)
                    .then(
                        response=>transition.next({
                            event: response.data.event,
                            numberOfParticipants: response.data.numberOfParticipants}),
                        ()=> transition.abort('get no data')
                    )
            }
        },
        components:{
            UpdateEvent
        },
        ready(){
          this.updateGA("event_detail_"+ this.$route.params.eventId)
        },
        data: function () {
            return {
                user: this.$root.$data.user,
                event: {},
                numberOfParticipants:0
            }
        },
        computed:{
          isMyEvent(){
                return this.user.id == this.event.user_id
            },
            availableForInvitation(){
                return moment() < moment(this.event.startDateTime)
            }
        },
        methods:{
              showModal(){
                  if(this.isMyEvent){
                      var target = $("#myModal");
                      target.modal('show');
                  }
              },
            clickInvite(){
                if(this.availableForInvitation){
                    console.log("invite others");
                }else{
                    console.log("cannot invite others")
                }
            },
            createNewEvent(data) {
                if (this.isMyEvent){
                    var uri = this.getApi("createEvent"),
                        headers = this.setRequestHeaders();
                    this.$http.post(uri, data, headers).then(
                        response => {
                            $("#myModal").modal('hide');
                            toastr.success("Event Updated!");
                            this.$emit('eventCreated', response.data.event)
                        },
                        response => console.log(response)
                    );
                }
            }
        },
        filters:{
            dateParser(date){
                if(date == "0000-00-00 00:00:00")
                    return ""
                return moment(date).format("LLL")
            }
        }
    }
</script>