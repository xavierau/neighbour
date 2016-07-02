<style> </style>
<template lang="html" src="html/shareModal.html"> </template>

<script>
export default{
    props:["feedId"],
    data(){
        return{
            email:""
        }
    },
    methods:{
        share(){
            this.$dispatch("shareFeed", this.feedId, this.email);
            
            this.email="";
        }
    }
}
</script>