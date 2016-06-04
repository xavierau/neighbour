<template lang="html" src="html/singleFeed.html"></template>

< script >
import Feed from './components/feed.vue';
export default{
    route:{
        data(transition){
            var uri = "/api/feed/"+this.$route.parameters.feedId,
                headers = this.setRequestHeaders();
            this.$http.get(uri, null, headers).then(
                ({data})=>{
                    console.log(data);
                    transition.next(data)
                },
                (response)=>{
                    console.log(response);
                }
            )
        }
    },
    ready(){
      console.log('form single feed')
    },
    components: {
        Feed
    }
}
< / script >