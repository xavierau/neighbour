<style>
    .comment-row{
        margin-bottom: 15px;
    }
</style>
<template>
    <div class=" comment-row">
        <img class="avatar pull-left" :src="comment.sender.avatar" alt="">
        <content-container
                class="comment-container"
                :sender="comment.sender.name"
                :sender-link="comment.avatarSrc"
                :content="comment.content"
        ></content-container>
    </div>
</template>

<script>
    import ContentContainer from "./content.vue"
    export default{
        props: {
            comment: {
                type: Object,
                required: true
            }
        },
        components: {
            ContentContainer
        }
    }
</script>