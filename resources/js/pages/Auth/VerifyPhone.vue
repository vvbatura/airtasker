<template>
    <div class="verify-form">
        <form v-on:submit.prevent="submit">
            <div class="row text-center">
                <div class="col">
                    <h1>Verified Email</h1>
                    <div class="form-group">
                        <p>{{message}}</p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Code" v-model.trim="$v.code.$model">
                        <div v-if="!$v.code.required && $v.code.$dirty" class="not-valid">Code is required</div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Verified</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import {email, maxLength, minLength, required} from "vuelidate/lib/validators";

    export default {
        data() {
            return {
                code: '',
                message: '',
            };
        },

        validations: {
            code: {
                required
            }
        },

        methods: {
            submit() {
                axios.get('/auth/verify', {
                    params: {
                        token: this.code,
                        type: 'phone'
                    }
                })
                .then(response => {
                        this.message = 'Successfully You verified email.';
                    }
                )
                .catch(error => {
                        this.message = 'Error You didn\'t verify email.';
                    }
                )
            }
        }
    }
</script>

<style scoped lang="scss">
    .verify-form {
        max-width: 500px;
        margin: 0 auto;
    }
</style>
