<style lang="scss" src="style/eventCreationForm.scss"></style>
<template lang="html" src="html/eventUpdateForm.html"></template>

    <script>

export default{
    props:{
        event:{
            type:Object,
        }
    },
    data(){
        return {
            showEndDateTime:false
        }
    },
    computed:{
    startDate(){
        return moment(this.event.startDate).format("YYYY-MM-DD")
      },
      startHour(){
          return moment(this.event.startDate).format("H")-1
      },
      startMin(){
          return moment(this.event.startDate).format("m")
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
                var form = document.getElementById("updateEventForm");
                var data = new FormData(form);
                this.$dispatch("updateEvent", data)
            }

        },
        selectEventPic: function (event) {
            var file = event.target.files[0],
                profilePicContainer = document.getElementById('eventPhoto');
            profilePicContainer.src = URL.createObjectURL(file);
            this.file = file;
        }
    }
}
</script>