<style lang="scss" src="style/eventCreationForm.scss"></style>
<template lang="html" src="html/eventUpdateForm.html"></template>

<script>
export default{
    props:{
        event:{
            type:Object
        }
    },
    data(){
        return {
            showEndDateTime:false
        }
    },
    computed:{
        eventPhoto(){
            if(this.event.media.length == 0)
                return "https://bimsync.com/images/Icon-Blue.png";
            return this.event.media[this.event.media.length-1].link;
        },
        startDate(){
        console.log(this.event);
        return moment(this.event.startDateTime).format("YYYY-MM-DD")
        },
        startHour(){
          return moment(this.event.startDateTime).format("H")-1
        },
        startMin(){
          return moment(this.event.startDateTime).format("m")
        },
        endDate(){
          if(this.event.endDate != "0000-00-00 00:00:00"){
              return moment(this.event.endDate).format("YYYY-MM-DD")
          }
        },
        endHour(){
          if(this.event.endDate != "0000-00-00 00:00:00"){
              return moment(this.event.endDate).format("H")-1
          }
        },
        endMin(){
          if(this.event.endDate != "0000-00-00 00:00:00"){
              return moment(this.event.endDate).format("m")
          }
      },
    },
    methods:{
        formIsValid: function () {
            var form = document.getElementById("updateEventForm");
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
        clickUpdateEvent: function () {
            if(this.formIsValid()){
                var form = $('#updateEventForm');
                console.log(form);
                console.log(form[0]);
                var data = new FormData(form[0]);
                console.log(data.get('name'));
                console.log(data.get('location'));
                this.$dispatch("updateEvent", data)
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