<style></style>
<template>
    <!-- Modal -->
    <div class=" modal fade" style="color:black" id="myModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <event-creation-form
                        :new-event.sync="newEvent"
                ></event-creation-form>
            </div>
        </div>
    </div>
</template>

<script>
    import EventCreationForm from "./eventCreationForm.vue";
    export default{
        props:{
            newEvent:{
                type:Object,
                twoWay:true
            }
        },
        components:{
            EventCreationForm
        }
    }
</script>