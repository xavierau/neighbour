<style></style>
<template lang = "html" src="html/search.html"></template>
    <script>
import TextFeed from "./components/commons/textFeed.vue";
export default{
    data(){
        return {
            searchText: "",
            newSearch:true,
            result: {
                current_page: 2,
                data: [],
                from: 0,
                last_page: 0,
                next_page_url: "",
                per_page: 0,
                prev_page_url: "",
                to: 0,
                total: 0
            }
        }
    },
    components: {
        TextFeed
    },
    methods: {
        search(){
            this.newSearch = true;
            var uri = "/api/search",
                headers = this.setRequestHeaders(),
                data = {query: this.searchText};
            this.$http.get(uri, data, headers)
                .then(({data})=>this.updatePaginator(data));
        },
        moreSearchResult(){
            this.newSearch = false;
            var uri = this.result.next_page_url,
                headers = this.setRequestHeaders(),
                data = {query: this.searchText};
            this.$http.get(uri, data, headers)
                .then(({data})=>this.updatePaginator(data));
            console.log(this.result.next_page_url)
        },
        updatePaginator(paginator){
            console.log(paginator)
            for(var key in paginator){
                if(key == "data" && !this.newSearch)
                    this.result[key].push.apply(this.result[key], paginator[key])
                else
                    this.result[key] = paginator[key]
            }
        }
    }
}
</script>

