<style></style>
<template lang = "html" src="html/search.html"></template>
    <script>
import TextFeed from "./components/commons/textFeed.vue";
import {appendSearchResult, resetSearchResult} from "./../actions"
import {getSearchResult} from "./../getters"
export default{
    vuex:{
        getters:{
            searchResult:getSearchResult
        },
        actions:{
            appendSearchResult,
            resetSearchResult
        }
    },
    data(){
        return {
            searchText: "",
            newSearch:true,
            result: {
                current_page: 2,
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
    ready(){
//        this.updateGA("search")
        console.log('this result array: ', this.searchResult)
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
            this.resetSearchResult()
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
        },
        updatePaginator(paginator){
            Object.keys(paginator).map(key=>{
                if(this.result.hasOwnProperty(key))
                    this.result[key]= paginator[key]
            })
            this.appendSearchResult(paginator['data'])
        }
    },
    destroyed(){
        this.resetSearchResult()
    }
}
</script>

