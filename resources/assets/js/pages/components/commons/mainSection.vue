<style lang="scss" src="style/mainSection.scss"></style>
<template lang="html" src="html/mainSection.html"></template>

<script>
    export default{
        props: {
            categoryList: {
                type: Array
            }
        },
        ready(){
            var uri = this.getApi("getMarqueeContent"),
                headers = this.setRequestHeaders();
            this.$http.get(uri, null, headers).then(({data})=>{
                var string ="";
                data.collection.map(item=>{
                    if(typeof item.startDateTime != "undefined"){
                        string += "-"+item.name+"- "
                    }else{
                        if(item.content.length > 30){
                            string += "-"+item.content.substr(0,30)+"...more - "
                        }else{
                            string += "-"+item.content+"- "
                        }
                    }
                });
                document.querySelector("div.marquee").innerHTML = string
            });


            // get avaliabe events
            // get hot deals
            // construct marquee
            // insert html to marquee
        }
    }
</script>