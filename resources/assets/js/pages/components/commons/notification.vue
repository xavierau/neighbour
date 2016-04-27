<style>
    li.notification.new{
        background-color: #02eac0;
    }
</style>
<template>
    <ul :class="myClass" :aria-labelledby="ariaLabelledby" style="color:black">
        <li v-for="notification in notifications" class="notification" :class="{'new':notification.is_new}">
            {{notification.user.name}} {{getMessage(notification)}}
        </li>
    </ul>

</template>

<script>
    export default{
        props: {
            myClass: {
                type: String
            },
            ariaLabelledby: {
                type: String
            },
            notifications: []
        },
        methods: {
            getMessage: function (notification) {
                var message = "";
                switch (notification.notifiable_type) {
                    case "App\\Feed":
                        message = "replay your feed '" + notification.notifiableObject.content.substr(0, 5) + "'"
                        break;

                    case "App\\Message":
                        message = "send you a message '" + notification.notifiableObject.message.substr(0, 5) + "'"
                        break;
                }
                return message;
            }
        }
    }
</script>