<style lang="scss" src="style/eventCreationForm.scss"></style>
<template lang="html" src="html/eventCreationForm.html"></template>

<script>
    export default{
        props:{
            newEvent:{
                type:Object,
                twoWay:true
            }
        },
        data(){
            return {
                showEndDateTime:false
            }
        },
        methods:{
            formIsValid: function () {
              var form = document.getElementById("createEventForm");
                var check=true;
                if(form.name.value.length<3){
                    toastr.warning('The event name at least 3 char long.');
                    check =false;
                }
                if(form.location.value.length<3){
                    toastr.warning('Should have a location right?');
                    check =false;
                }
                if(!form.startDate.value){
                    toastr.warning('Come on, let me know when it start');
                    check =false;
                }
                if(!form.description.value){
                    toastr.warning('Tell me something about the event, plsss.');
                    check =false;
                }
                return check;
            },
            clickCreateEvent: function () {
                if(this.formIsValid()){
                    var form = document.getElementById("createEventForm");
                    var data = new FormData(form);
                    this.$dispatch("createNewEvent", data)
                }

            },
            selectEventPic: function (event) {
                var file = event.target.files[0],
                        profilePicContainer = document.getElementById('eventPhoto');
                profilePicContainer.src = URL.createObjectURL(file);
                this.file = file;
            }
        },
        filters:{
            leftPadding(value){
                var str = "" + value
                var pad = "00"
                var ans = pad.substring(0, pad.length - str.length) + str
                return ans
            }
        }
    }
</script>