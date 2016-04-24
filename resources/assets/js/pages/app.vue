<style>
    div.main-container {
        position: relative;
        top: 80px;
    }

    div.inputContainer {
        background: white;
        padding: 10px;
    }

    div.inputContainer select {
        border-radius: 0;
    }

    div.inputContainer textarea {
        border: none;
        box-shadow: none;
    }

    div.inputContainer textarea:focus {
        box-shadow: none;
    }

    div.inputContainer input[type='submit'] {
        border-radius: 0;
    }

    ul.unstyled.list-group li.list-group-item {
        border: none;
        border-radius: 0;
        background-color: transparent;
    }

    ul.unstyled.list-group li.list-group-item a {
        color: black;
    }

    ul.unstyled.list-group {
        border: none;
        color: black;
    }

    div.main-actions {
        background-color: white;
        color: grey;
    }

    div.main-actions div.active {
        color: black;
    }

    div.mobile-input {
        position: fixed;
        bottom: 10px;
        left: 0;
        right: 0;
        width: 90%;
        margin: 0 auto;
    }

    div.mobile-input div.mobile-textarea {
        width: 100%;
        background-color: white;
        color: black;
        padding: 5px;
    }
</style>
<template>
    <header-nav
        :user="user"
        :category-list="categoryList"
    ></header-nav>

    <main-section :category-list="categoryList">
        <router-view
                :user="user"
                :category-list="categoryList"
        ></router-view>
    </main-section>
</template>

<script>
    import HeaderNav from './components/commons/headerNav.vue';
    import MainSection from './components/commons/mainSection.vue';
    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi('categoryList');
                this.$http.get(uri).then(function (response) {
                    transition.next({
                        categoryList : response.data
                    });
                }, function () {
                    transition.abort("cannot fetch category list.");
                });

            }
        },
        components: {
            HeaderNav,
            MainSection
        },
        data: function () {
            return {
                user: this.$root.$data.user,
                categoryList: []
            }
        },
        events:{
            userHasBeenUpdated:function(newUser){
                this.$set('user', newUser);
            }
        }

    }
</script>