<style lang="scss" src="style/headerNav.scss"></style>
<template lang="html" src="html/headerNav.html"></template>

<script>
    var socket;
    import Notifications from './notification.vue';
    export default{
        created () {
            socket = require('socket.io-client')(":3000");
        },
        beforeDestroy () {
            socket.disconnect();
        },
        ready () {
            var channel = "neighbourApp:notification:newNotification_" + this.user.id;
            console.log(channel);
            socket.on(channel, data=> {
                console.log(data);
                this.user.notificationsCount = data;
                this.user.has_notification = true;
            })
            $('#commenting').on('shown.bs.modal', function () {
                $('#commentingInput').focus()
            })
            $('#commenting').on('hidden.bs.modal', ()=>this.comment="")
        },
        props: {
            user: {
                type: Object,
                required: true
            },
            categoryList: {
                type: Array
            },
            notifications: {
                type: Array
            }
        },
        data(){
            return{
                comment:""
            }
        },
        components: {
            Notifications
        },
        computed:{
            appName(){
                return document.querySelector("meta[name='appName']").getAttribute("content");
            }
        },
        methods: {
            showDirectory(){
                $('#directory').modal("show")
            },
            commenting(){
                $('#commenting').modal("show")
            },
            sendComment(){
                var headers = this.setRequestHeaders();
              this.$http.post("/commenting", {comment:this.comment}, headers).then(()=> {
                  toastr.success("Your comment is very much appreciated! Thanks!");
                  $('#commenting').modal("hide");
                  this.comment = ""
              }, ()=>toastr.warning("Something Wrong, please try again later!"))
            },
            getNotifications: function () {
                if (this.user.has_notification) {
                    var uri = this.getApi("notifications"),
                            data = null,
                            headers = this.setRequestHeaders();
                    this.$http.get(uri, data, headers).then(function (response) {
                        return this.$set('notifications', response.data.notifications);
                    }.bind(this));


                    uri = this.getApi("acknowledgedNotifications"),
                            data = null,
                            headers = this.setRequestHeaders();
                    this.$http.get(uri, data, headers);

                    this.user.has_notification = false;
                }

            },
            logout: function () {
                this.$dispatch('logout');
            }
        }
    }
</script>