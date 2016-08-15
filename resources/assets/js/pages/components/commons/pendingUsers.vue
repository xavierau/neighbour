<template lang="html" src="html/pendingUsers.html"></template>

<script type="text/babel">
    export default {
        data(){
            return{
                pendingUsers:[]
            }
        },
        computed:{
            showBuildingName(){
                return this.pendingUsers.length > 0 && this.pendingUsers[0].hasOwnProperty("clan")
            }
        },
        ready(){
            var uri = this.getApi("getPendingUsers"),
                    headers = this.setRequestHeaders();
            this.$http.get(uri, "", headers).then(({data}) => {
                        console.log(data);
                        this.pendingUsers = data.PendingUsers;
                    }, response => console.log(response)
            )
        },
        methods:{
            approveUser(user){
                var uri = this.getApi("approveUser")+"/"+user.id,
                        headers = this.setRequestHeaders();
                this.$http.put(uri, "", headers).then(({data}) => {
                            if(data.Status == "approved"){
                                this.pendingUsers.$remove(user);
                                toastr.success("User Approved!");
                            }else{
                                toastr.warning("Cannot Approve User!");
                            }
                        }, response => {
                            console.log(response)
                            toastr.warning("Something wrong, try again later!");
                        }
                )
            }
        }
    }
</script>