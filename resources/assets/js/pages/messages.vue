<style>
    .standard.stream-container {
        margin-top: 15px;
    }

    div.messageContainer div.message {
        display: inline-block;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
        background: rgba(255, 255, 255, 0.8);
    }

    div.messageContainer.myMessage div.message {
        text-align: right;
        background: rgba(34, 255, 46, 0.8);
    }

    div.messagesContainer.row {
        margin-top: 15px;
    }
    img.profile{
        display: inline-block;
        height: 50px;
        width: 50px;
        border-radius: 25px;
    }

</style>
<template>
    <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
        <div class="col-xs-12">
            <img :src="recipient.avatar" alt="" class="profile">
            <p>{{recipient.name}}</p>
        </div>
        <form action="">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" @click="clickCamera">
                        <i class="fa fa-camera"></i>
                    </span>
                    <textarea class="form-control" name="message" id="" cols="30" rows="3" v-model="newMessage"> </textarea>
                    <span class="input-group-addon" @click.prevent="sendMessage">
                        <p>Send</p>
                    </span>
                </div>
            </div>
        </form>
        <div class="messagesContainer row" v-for="message in messages">
            <div class="col-xs-8 {{notMe(message)}} messageContainer">
                <div class="message">
                    {{message.message}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    var socket;
    import store from "./../store";
    import {getUser} from "./../getters";
    export default{
        vuex:{
            getters:{
                user:getUser
            }
        },
        route: {
            data: function (transition) {
                var uri = this.getApi("conversationMessages") + "/" + this.$route.params.conversationId,
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        messages: response.data.messages,
                        recipient: response.data.recipient
                    });
                }, function () {
                    transition.abort("cannot fetch user data");
                })
            },
            activate: function (transition) {
                socket = require('socket.io-client')(":3000");
                transition.next()
            },
            deactivate: function (transition) {
                socket.disconnect();
                transition.next();
            }
        },
        data: function () {
            return {
                recipient:{},
                newMessage: "",
                messages: []
            }
        },
        ready(){
            this.updateGA("conversation");
            var channel = "neighbourApp:message:conversation_" + this.$route.params.conversationId;
            socket.on(channel, function (data) {
                this.messages.unshift(data);
            }.bind(this))
        },
        methods: {
            clickCamera(){
              console.log('camera click')
            },
            notMe: function (message) {
                return this.user.id == message.user_id ? "pull-right text-right myMessage" : "";
            },
            sendMessage: function () {
                var uri = this.getApi("conversationMessages"),
                        data = {
                            message: this.newMessage,
                            conversationId: this.$route.params.conversationId
                        },
                        headers = this.setRequestHeaders();
                this.$http.post(uri, data, headers).then(function () {
                    this.newMessage = "";
                }, function (response) {
                    console.log(response);
                })
            }
        }
    }
</script>