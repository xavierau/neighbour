<style>
    li.conversation {
        margin-bottom: 15px;
    }

    img.avatar {
        width: 60px;
        height: 60px;
        border-radius: 30px;
    }
    ul.searchResult{
        max-height: 150px;
        background-color: rgba(255, 255, 255, 0.4);
        overflow: scroll;
    }
    ul.searchResult img{
        display: inline-block;
        height: 30px;
        width: 30px;
        border-radius: 15px;
    }
</style>
<template>
    <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
        <div class="form-group">
            <label for="receiver">Send Message To:</label>
            <div class="col-sm-6 col-md-4">
                <input class="form-control" type="text" id="receiver" v-model="searchTerm" @keyup.prevent="searchUser">
            </div>
            <ul class="list-unstyled searchResult" v-show="searchTerm.length > 0">
                <li v-for="user in searchUserResult" @click.prevent="message(user)">
                    <img :src="user.avatar" alt="">
                    <p>{{user.first_name}} {{user.last_name}}</p>
                </li>
            </ul>
        </div>

        <h4>You have following conversations:</h4>
        <ul class="list-unstyled" >
            <li class="conversation" v-for="conversation in conversations">
                <a v-link="{name:'messages', params:{conversationId:conversation.id}}">
                    <div style="display: inline-block">
                        <img class="avatar" :src="conversation.users[0].avatar" alt="">
                    </div>
                    <div style="display: inline-block">
                        <h5>Conversation with: {{conversation.users[0].name}}</h5>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    import store from "./../store";
    import {updateUser} from "./../actions";
    import {getUser} from "./../getters";
    export default{
        vuex:{
            actions:{
                updateUser
            },
            getters:{
                user:getUser
            }
        },
        route: {
            data: function (transition) {
                var uri = this.getApi("allConversation"),
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        conversations: response.data.conversations
                    });
                }, function () {
                    transition.abort("cannot fetch user data");
                })
            }
        },
        ready(){
          this.updateGA("conversation")
        },
        data: function () {
            return {
                conversations: [],
                searchUserResult: [],
                searchTerm:""
            }
        },
        methods: {
            message:function (user) {
                var uri = this.getApi("getTheConversation"),
                        data = {receiverId: user.id},
                        headers = this.setRequestHeaders();
                this.$http.get(uri, data, headers).then(function (response) {
                    console.log('get conversation, ',response.data);
                    this.$router.go({name:'messages', params:{conversationId: response.data.conversation.id}})
                }, function (response) {
                    console.log(response);
                })
            },
            searchUser() {
                if(this.searchTerm.length > 0){
                    var uri = this.getApi("searchUserByUserName"),
                        data = {name: this.searchTerm},
                        headers = this.setRequestHeaders();
                    this.$http.get(uri, data, headers).then(
                        ({data}) => this.$set('searchUserResult', data.users),
                        response => console.log(response)
                    )
                }else{
                    this.searchUserResult = [];
                }
            }
        }
    }
</script>