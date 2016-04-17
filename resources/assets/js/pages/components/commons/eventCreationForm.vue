<style>

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
                    <input type="text" id="name" class="form-control col-sm-10" placeholder="Add a name">
                </div>
            </div>
            <div class="form-group">
                <label for="location" class="col-sm-2">Location</label>
                <div class="col-sm-10">
                    <input type="text" id="location" class="form-control col-sm-10"
                           placeholder="Include a place or event">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2">Date/Time</label>
                <div class="col-sm-5">
                    <input type="text" id="startTime" class="form-control" placeholder="Start Date and Time">
                </div>
                <div class="col-sm-5">
                    <input type="text" id="endTime" class="form-control" placeholder="End Date and Time">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2">Description</label>
                <div class="col-sm-10">
                    <textarea id="description" class="form-control col-sm-10"
                              placeholder="Describe your event"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="photo" class="col-sm-2">Event Photo</label>
                <div class="col-sm-10">
                    <input type="file" id="photo" class="form-control col-sm-10"/>
                </div>
            </div>
            <div class="form-group">
                <label for="eventType" class="col-sm-2">Event Type</label>
                <div class="col-sm-10">
                    <select name="eventType" id="eventType" class="form-control
                    ">
                        <option value="1" selected>Private</option>
                        <option value="2">Public</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Create Event</button>
        </div>
    </form>
</template>

<script>
    export default{}
</script>