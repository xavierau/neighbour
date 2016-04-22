<style>
    #profilePic {
        height: 120px;
        width: 120px;
        border-radius: 60px;
        margin-bottom: 15px;
    }

    .standard.stream-container {
        margin-top: 15px;
    }
</style>
<template>
    <div class="standard stream-container col-sm-8 col-md-7">
        <div class="center-block">
            <img :src="user.avatar"
                 alt="" id="profilePic">
        </div>
        <form id="profile">
            <input name="id" :value="user.id" type="hidden"/>
            <div class="form-group">
                <label for="name">User Name:</label>
                <input type="text" id="name" name="name" class="form-control" v-model="user.name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" v-model="user.email">
            </div>
            <div class="form-group">
                <label for="avatar">Avatar:</label>
                <input
                        type="file"
                        id="avatar"
                        name="file"
                        class="form-control"
                        @change.prevent="selectProfilePic"
                        accept="image/*">
            </div>
            <div class="form-group" v-show="!wantToChangePassword">
                <button
                        class="btn-default btn"
                        @click.prevent="wantToChangePassword=true"
                >Change Password
                </button>
            </div>

            <div v-show="wantToChangePassword">
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="text" id="password" name="password" class="form-control" v-model="password">
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password:</label>
                    <input type="text" id="password_confirmation" class="form-control" v-model="password_confirmation">
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-success" @click.prevent="updateProfile">Update Profile</button>
                <button class="btn btn-success" @click.prevent="BackToHome">Back</button>
            </div>

        </form>
    </div>
</template>

<script>
    export default{
        route: {
            data: function (transition) {
                var uri = this.getApi("userProfile"),
                        data = null,
                        headers = this.setRequestHeaders();
                this.$http.get(uri, data, headers).then(function (response) {
                    transition.next({
                        user: response.data
                    });
                }, function () {
                    transition.abort("cannot fetch user data");
                })
            }
        },
        data: function () {
            return {
                user: {},
                profilePic: null,
                file:{},
                wantToChangePassword: false,
                password: "",
                password_confirmation: ""
            }
        },
        methods: {
            selectProfilePic: function (event) {
                var file = event.target.files[0],
                        profilePicContainer = document.getElementById('profilePic');
                profilePicContainer.src = URL.createObjectURL(file);
                this.file = file;
            },
            updateProfile: function () {
                var uri = this.getApi("userProfile"),
                        headers = this.setRequestHeaders();

                if (this.wantToChangePassword && this.password.length > 0) {
                    if (!this.isValidPasswordInputs()) {
                        console.log("incorrect password inputs");
                        return;
                    }
                }

                var form = document.querySelector("form#profile");
                console.log(form);
                var data = new FormData(form);
                this.$http.post(uri, data, headers)
                        .then(function (response) {
                            if (response.data.hasOwnProperty('user')){
                                var message = {
                                    active: true,
                                    type: "success",
                                    message: "User have been updated"
                                };
                                this.$dispatch('updateUser', response.data.user);
                                toastr.success("update successfully");
                                this.$router.go({name: 'home'})
                            }

                        }, function (response) {

                        });
            },
            isValidPasswordInputs: function () {
                return this.password == this.password_confirmation
            },
            BackToHome: function () {
                this.$router.go({name: 'home'})
            }
        }
    }
</script>