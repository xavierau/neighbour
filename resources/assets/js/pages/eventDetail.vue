<style></style>
<template lant="html" src="html/eventDetail.html"></template>

<script>
    import UpdateEvent from './components/commons/updateEvent.vue';
    import store from "./../store";
    import {updateUser} from "./../actions";
    import {getUser} from "./../getters";
    export default{
        vuex:{
            actions:{
                updateUser
            },
            getters:{
                user:getUser
            }
        },
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
        data () {
            return {
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
            },
            deleteEvent(){
                this.$http.post("/api/events/"+this.event.id, {'_method':"DELETE"}, this.setRequestHeaders())
                    .then(()=>{
                        toastr.success('event deleted!')
                        this.$router.go({name:"events"})
                    },
                        response=>console.log(response)
                    )

            }
        },
        events:{
            updateEvent(eventFormData){
                eventFormData.append("_method", "PUT");
                toastr.info('Updating...');
                this.$http.post("/api/events/"+this.event.id, eventFormData, this.setRequestHeaders())
                    .then(
                        ({data})=>{
                            toastr.clear();
                            toastr.success("Successfully update");
                            this.event = data.event;
                            $("#myModal").modal("hide")
                        },
                        response=>console.log(response)
                    )
            }
        },
        filters:{
            dateParser(date){
                if(date == "0000-00-00 00:00:00" || date == "-0001-11-30 00:00:00")
                    return "";
                return moment(date).format("LLL")
            }
        }
    }
</script>