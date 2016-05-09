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
        <button class="unstyled"
                @click.prevent="deleteComment"
                v-show="comment.sender.id == user.id"
        ><i class="fa fa-trash" aria-hidden="true"></i>
            Delete
        </button>
    </div>
</template>

<script>
    import ContentContainer from "./content.vue"
    export default{
        props: {
            comment: {
                type: Object,
                required: true
            },
            user:{
                type:Object
            }
        },
        components: {
            ContentContainer
        },
        methods:{
            deleteComment: function () {
                this.$dispatch("deleteCommentEvent", this.comment)
            }
        }
    }
</script>