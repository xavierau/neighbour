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

</style>
<template>
    <div class="col-sm-offset-3 col-md-offset-2 col-sm-8 col-md-7">
        <form action="">
            <div class="form-group">
                <textarea class="form-control" name="message" id="" cols="30" rows="3" v-model="newMessage"> </textarea>
            </div>
            <button class="btn btn-primary" @click.prevent="sendMessage">Send</button>
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
    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi("conversationMessages") + "/" + this.$route.params.conversationId,
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        messages: response.data.messages
                    });
                }, function () {
                    transition.abort("cannot fetch user data");
                })
            },
            activate: function (transition) {
//                var url = "http://oup25o.anacreation.com:3000";
//                var url = window.location.host + ":3000";
                socket = require('socket.io-client')(":3000");
                transition.next()
            },
            deactivate: function (transition) {
                socket.disconnect();
                transition.next();
            }
        },
        props: {
            user: {
                type: Object
            }
        },
        data: function () {
            return {
                newMessage: "",
                messages: []
            }
        },
        ready: function () {
            var channel = "neighbourApp:message:conversation_" + this.$route.params.conversationId;
            socket.on(channel, function (data) {
                this.messages.unshift(data);
            }.bind(this))
        },
        methods: {
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