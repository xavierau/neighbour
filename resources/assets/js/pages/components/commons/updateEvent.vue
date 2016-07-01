<style></style>
<template>
<!-- Modal -->
<div class=" modal fade" style="color:black" id="myModal" tabindex="-1" role="dialog"
aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <event-update-form :event="event"></event-update-form>
            </div>
        </div>
    </div>
</template>

    <script>
import EventUpdateForm from "./eventUpdateForm.vue";
export default{
    props:{
        event:{
            type:Object
        }
    },
    ready(){
      console.log("from ready, "+this.event.pic);
    },
    components:{
        EventUpdateForm
    }
}
</script>