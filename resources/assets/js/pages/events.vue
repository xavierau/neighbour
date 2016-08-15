<style lang = "scss" src = "style/events.scss"> </style>
<template lang = "html" src = "html/events.html"> </template>


<script>
import EventContainer from "./components/commons/eventContainer.vue";
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
    components: {
        EventContainer
    },
    ready(){
        this.updateGA("events");
        $('#eventInviteModal').on('hidden.bs.modal', ()=> {
            this.searchName = "";
            this.searchUserResult=[];
        })
    },
    data () {
        return {
            myEvents: [],
            publicEvents: [],
            tempEvent: {},
            searchUserResult: [],
            inviteButtonText: "invite",
            searchName:""
        }
    },
    events: {
        inviteEvent(event){
            this.tempEvent = event;
            $('#eventInviteModal').modal('show')
        }
    },
    filters:{
        showButtonText(value, userId){
            return this.isUserInvited(userId)? "Invited" : "Invite"
        }
    },
    methods: {
        isUserInvited(userId){
            result = this.tempEvent.invitations.filter(invitation=>invitation.receiver_id == userId)
            return result.length > 0
        },
        updateInvitationList(invitationList){
            console.log(this.tempEvent.invitations)

            this.$set("tempEvent.invitations",invitationList);
            // this.tempEvent.invitations = invitationList
            console.log(this.tempEvent.invitations)


        },
        inviteUser(userId){
            if (!this.isUserInvited(userId)){
                var uri = "/api/invitation/event/" + this.tempEvent.id + "/user/" + userId;

                this.$http.get(uri).then(
                    ({data})=>{
                        if(data.status){
                            console.log(data.invitationList);
                            this.updateInvitationList(data.invitationList)
                        }
                    },
                    response=>console.log(response)
                );

                console.log(uri)
            }
        },
        searchUser(){
            var uri = this.getApi("searchUserByUserName"),
                data = {name: this.searchName},
                headers = this.setRequestHeaders();
            this.$http.get(uri, data, headers).then(function (response) {
                this.$set('searchUserResult', response.data.users);
                console.log(this.searchUserResult)
            }, function (response) {
                console.log(response);
            })
        }
    }
}
</script>