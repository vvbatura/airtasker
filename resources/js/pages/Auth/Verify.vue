<template>
    <div class="row text-center">
        <div class="col">
            <h1>Email successfully verified</h1>
            <router-link :to="{name: 'login'}">Return to Login</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                token: ''
            };
        },

        created() {
            this.verify();
        },

        methods: {
            verify() {
                axios.get({
                    token: this.$route.token
                })
                .then(response => {
                        alert('Email was verified')
                    }
                )
                .catch(
                    error => {
                        console.log(error);
                    }
                )
            }
        }
    }
</script>

