<style></style>
<template>
    <div class="col-md-6 eventContainer">
        <div class="row" >
            <div class="col-xs-4">
                <a v-link="{name:'eventDetail', params:{eventId:event.id}}">
                    <img src="https://cdn1.iconfinder.com/data/icons/delivery-logistics/512/delivery_date-512.png"
                         alt="" class="img-responsive">
                </a>
            </div>
            <div class="col-xs-8">
                <a v-link="{name:'eventDetail', params:{eventId:event.id}}">
                    <h4>{{event.name}}</h4>
                </a>
                <p>{{event.location}}</p>
                <ul class="list-inline">
                    <li>Going</li>
                    <li>Maybe</li>
                    <li>Pending</li>
                </ul>
            </div>
            <div class="col-xs-12">
                <div class="btn-group btn-group-justified" role="group" aria-label="..." style="margin-bottom: 10px">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-xs">Invite</button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default btn-xs">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            event:{
                type:Object
            }
        }
    }
</script>