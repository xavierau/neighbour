<style lang="scss" src="style/app.scss"></style>

<template>
    <header-nav
            :category-list="categoryList"
            :notifications="notifications"
            keep-alive
    ></header-nav>

    <main-section :category-list="categoryList">
        <router-view
                :user="user"
                :category-list="selectCategoryList"
        ></router-view>
    </main-section>
    <simple-user-list></simple-user-list>
    <share-modal></share-modal>
</template>

<script>
    import HeaderNav from './components/commons/headerNav.vue';
    import MainSection from './components/commons/mainSection.vue';
    import SimpleUserList from './components/commons/whoLike.vue';
    import ShareModal from './components/commons/shareModal.vue';
    import store from "./../store";
    import {updateUser} from "./../actions";
    import {getUser} from "./../getters";
    export default{
        vuex:{
          actions:{
              updateUser
          },
            getters:{
              user:getUser
            }
        },
        route: {
            data: function (transition) {
                var requiredFetch = {
                            categoryList: false,
                            selectCategoryList: false,
                            notifications: false
                        },
                        data = {
                            categoryList: [],
                            notifications: [],
                            selectCategoryList:[]
                        };

                var uri = this.getApi('categoryList');
                this.$http.get(uri).then(
                    response => {
                    requiredFetch.categoryList = true;
                    data.categoryList = response.data;
                    if (this.everyPairIsTrue(requiredFetch)) transition.next(data);
                }, () => transition.abort("cannot fetch category list."));

                uri = this.getApi('notifications');
                this.$http.get(uri).then(response=> {
                    requiredFetch.notifications = true;
                    data.notifications = response.data.notifications;
                    if (this.everyPairIsTrue(requiredFetch)) transition.next(data);
                },  () => transition.abort("cannot fetch category list."));

                uri = this.getApi('selectCategoryList');
                this.$http.get(uri).then(response => {
                    requiredFetch.selectCategoryList = true;
                    data.selectCategoryList = response.data;
                    if (this.everyPairIsTrue(requiredFetch)) transition.next(data);
                }, () => transition.abort("cannot fetch selected category list."));
            }
        },
        components: {
            HeaderNav,
            MainSection,
            SimpleUserList,
            ShareModal
        },
        data: function () {
            return {
                categoryList: [],
                notifications:[],
                selectCategoryList:[]
            }
        },
        events: {
            userHasBeenUpdated: function (newUser) {
                this.updateUser(newUser)
            }
        }

    }
</script>