<style></style>
<template>
    <div class="hidden-xs ">
        <div class=" main-actions">
            <div class="col-xs-6 active">
                <p class="text-center">Feed</p>
            </div>
            <div class="col-xs-6">
                <p class="text-center" @click.prevent="showCreateEventModal">Create Event</p>
            </div>
        </div>
        <div class="clearfix inputContainer">
            <form action="" class="form">
                <div class="form-group">
                        <textarea
                                name="replay"
                                class="form-control"
                                id=""
                                cols="30"
                                rows="3"
                                v-model="content"
                        ></textarea>
                </div>
                <input
                        type="submit"
                        class="btn btn-default pull-right"
                        value="Update"
                        @click.prevent="clickUpdate">
                <div class="col-xs-3 pull-right">
                    <select name="type" class="form-control" v-model="category_id">
                        <option v-for="category in categoryList" :value="category.id">{{category.name}}</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            content:{
                type:String,
                twoWay: true
            },
            category_id:{
                type:Number,
                twoWay: true
            },
            categoryList:{
                type: Array
            }
        },
        methods: {
            clickUpdate: function () {
                this.$dispatch('updateFeed')
            },
            showCreateEventModal: function(){
                this.$dispatch("showCreateEventModalEvent")
            }
        }
    }
</script>