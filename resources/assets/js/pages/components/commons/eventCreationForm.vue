<style>
 img#eventPhoto{
     max-height: 100px;
 }
</style>
<template>
    <form class="form-horizontal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Create A New Event</h4>
        </div>
        <div class="modal-body clearfix">
            <div class="form-group">
                <label for="name" class="col-sm-2">Event Name</label>
                <div class="col-sm-10">
                    <input type="text" id="name" class="form-control col-sm-10" placeholder="Add a name" v-model="newEvent.name">
                </div>
            </div>
            <div class="form-group">
                <label for="location" class="col-sm-2">Location</label>
                <div class="col-sm-10">
                    <input type="text" id="location" class="form-control col-sm-10"
                           placeholder="Include a place or event" v-model="newEvent.location">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2">Date/Time</label>
                <div class="col-sm-5">
                    <input type="datetime" id="startDateTime" class="form-control" placeholder="Start Date and Time" v-model="newEvent.startDateTime">
                </div>
                <div class="col-sm-5">
                    <input type="datetime" id="endDateTime" class="form-control" placeholder="End Date and Time" v-model="newEvent.endDateTime">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2">Description</label>
                <div class="col-sm-10">
                    <textarea id="description" class="form-control col-sm-10"
                              placeholder="Describe your event" v-model="newEvent.description"></textarea>
                </div>
            </div>

            <div class="form-group  clearfix">
                <div class="col-md-10 pull-right">
                    <img src="https://bimsync.com/images/Icon-Blue.png" alt="" id="eventPhoto">
                </div>
            </div>
            <div class="form-group">
                <label for="pic" class="col-sm-2">Event Photo</label>
                <div class="col-sm-10">
                    <input type="file"
                           id="pic"
                           class="form-control col-sm-10"
                           @change.prevent="selectEventPic"
                    />
                </div>
            </div>
            <div class="form-group">
                <label for="isPublic" class="col-sm-2">Event Type</label>
                <div class="col-sm-10">
                    <select name="isPublic" id="isPublic" class="form-control" v-model="newEvent.isPublic">
                        <option value="0">Private</option>
                        <option value="1">Public</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click.prevent="clickCreateEvent">Create Event</button>
        </div>
    </form>
</template>

<script>
    export default{
        props:{
            newEvent:{
                type:Object,
                twoWay:true
            }
        },
        methods:{
            clickCreateEvent: function () {
                this.$dispatch("createNewEvent")
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