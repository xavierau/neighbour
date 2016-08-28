<style> </style>
<template lang="html" src="html/whoLike.html"></template>

<script>
    import {getSimpleUserList} from "./../../../getters"
export default{
        vuex:{
            getters:{
                userList: getSimpleUserList
            }
        }
}
</script>