<style> </style>
<template lang="html" src="html/shareModal.html"> </template>

<script>
    import {getShareItem} from "./../../../getters"
export default{
        vuex:{
            getters:{
                shareItem:getShareItem
            }
        },
    data(){
        return{
            email:""
        }
    },
    methods:{
        share(){
            $("#shareWithOthers").modal("hide");

            var item = this.shareItem.type == "event" ? "event" : "message"
            var message = "You have just shared a LocalHood "+item+" as the case may be  with "+this.email
            toastr.info(message);
            var headers = {
                headers:{
                    "X-CSRF-TOKEN": document.querySelector("meta[name='csrf_token']").getAttribute('content')
                }
            }
            this.$http.post("/api/share/"+this.shareItem.type+"/"+this.shareItem.id,{email:this.email}, null, headers)
                .then(
                        response=>console.log(response),
                        response=>console.log(response)
                );
        }
    }
}
</script>