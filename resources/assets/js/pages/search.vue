<style> </style>
<template lang="html" src="html/search.html"></template>

<script>
    export default{
        data(){
            return{
                searchText:""
            }
        },
        methods:{
            search(){
                console.log(this.searchText)
            }
        }
    }
</script>

