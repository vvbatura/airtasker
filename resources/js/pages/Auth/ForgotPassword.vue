<template>
   <form class="reset-form" @submit.prevent="submit">
        <h2 class="text-center mb-5">Reset password</h2>
        <div class="form-group">
            <div class="input-group">
               <input
                   type="text" v-model="$v.email.$model" @keyup="has_error = false"
                   class="form-control" name="email" placeholder="Enter your Email"/>
            </div>
            <span v-if="!$v.email.required && $v.$dirty" class="text-danger">Email is required</span>
            <span v-if="!$v.email.email && $v.email.$dirty" class="text-danger">Email not found</span>
            <span v-if="!$v.email.maxLength && $v.email.$dirty" class="text-danger">Max email length is 255</span>
            <span v-if="has_error && $v.email.$dirty && !$v.email.$invalid" class="text-danger">Email not found</span>
        </div>

        <div class="form-group ">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Reset password</button>
        </div>
        <div class="login-register">
            <router-link :to="{name: 'login'}">Return to Login</router-link>
        </div>
    </form>
</template>

<script>
import { required, email, maxLength } from 'vuelidate/lib/validators';

export default {
    data: function () {
        return {
            error_dialog: false,
            dialog: false,
            email: '',
            has_error: false
        };
    },

    validations: {
        email: {
            required,
            email,
            maxLength: maxLength(255)
        }
    },

    methods: {
        submit() {
            if (this.$v.$invalid) {
                return;
            }

            this.has_error = false;

            axios
                .post('auth/forgot-password', {
                    email: this.email
                })
                .then(response => {
                    alert('Check your email')
                })
                .catch(error => {
                    switch (error.response.status) {
                        case 422:
                            this.has_error = true;
                            break;
                        default:
                            this.error_dialog = true;
                            break;
                    }
                })
        },
    }
};
</script>

<style scoped lang="scss">
    .reset-form {
        max-width: 500px;
        margin: 0 auto;
    }
</style>
