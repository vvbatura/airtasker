<template>
    <div class="account_box text-center">
        <h2  v-if="verifiedAccount" class="verified_h mb-4">Account successfully verified</h2>
        <h2 class="mb-3" v-else>{{ message }}</h2>
        <router-link class="link_login btn-lg" to="/login">Return to Login</router-link>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: '',
            verifiedAccount: true,
            message: '',
            error_dialog: ''
        };
    },
    created() {
        axios.post('/auth/verify', {
            token: this.$route.params.token
        })
        .then(response => {
                console.log("check")
            }
        )
        .catch(error => {
                this.verifiedAccount = false;
                switch (error.response.status) {
                    case 400:  //not valid token
                        this.message = 'Not valid token';
                        break;
                    case 405:  //not valid token
                        this.message = 'Not valid token';
                        break;
                    case 409:   //conflict, something happend
                        this.message = 'Conflict, something happend';
                        break;
                    case 422:   //not the same password
                        this.message = 'Not the same password';
                        break;
                    default:
                        this.error_dialog = true;
                        break;
                }
            }
        )
    },
    beforeMount() {
        this.getTokens();
    },
    methods: {
        getTokens() {
            this.token = this.$route.params.token;
        }
    }
}
</script>

<style lang="scss">
.link_login {
    text-decoration: none;
    &:hover {
        text-decoration: none;
    }
}
.account_box {
    margin: 0 auto;
    padding: 0 15px;
}
</style>
