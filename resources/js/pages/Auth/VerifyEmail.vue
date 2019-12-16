<template>
    <div class="row text-center">
        <div class="col">
            <h1>Email successfully verified</h1>
            <router-link :to="{name: 'login'}" v-if="success">Return to Login</router-link>
            <p v-else>Error with verify.</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            token: '',
            success: false,
        };
    },
    created() {
        this.verify();
    },
    methods: {
        verify() {
            axios.get('/auth/verify', {
                params: {
                    token: this.$route.params.token,
                    type: 'email'
                }
            })
            .then(response => {
                    this.success = true;
                }
            )
            .catch(error => {
                    //console.log(error);
                }
            )
        }
    }
}
</script>

