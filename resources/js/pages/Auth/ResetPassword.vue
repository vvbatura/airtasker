<template>
    <div class="row mb-5 text-center">
        <div class="col">
            <form class='form-horizontal' role='form' @submit.prevent="submit">
                <div class='row'>
                    <div class='col-md-3'></div>
                    <div class='col-md-6'>
                        <h2>Change password</h2>
                        <hr>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='email'>E-Mail Address</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'><i class='fa fa-at'></i></div>
                                <input type='text' v-model="$v.email.$model" class='form-control' id='email'
                                       placeholder='you@example.com' autofocus autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="!$v.email.required && $v.$dirty"
                        class='col-md-3'>
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'> Email is required</i>
                    </span>
                        </div>
                    </div>
                    <div
                        v-if="!$v.email.email && $v.$dirty"
                        class='col-md-3'>
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'> Email must be email</i>
                    </span>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="errors.email && has_error">
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'>{{errors.email | toString() }}</i>
                    </span>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='password'>Password</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group has-danger'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'><i class='fa fa-key'></i></div>
                                <input type='password' v-model.trim="$v.password.$model" class='form-control' id='password' placeholder='Password'>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="!$v.password.required && $v.password.$dirty"
                        class='col-md-3'>
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'> Password is required</i>
                    </span>
                        </div>
                    </div>
                    <div
                        v-if="!$v.password.minLength && $v.password_confirmation.$dirty || !$v.password.maxLength && $v.password_confirmation.$dirty"
                        class='col-md-3'>
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'> Password must contain at least 6 characters and less 20</i>
                    </span>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='password_confirmation'>Confirm Password</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'>
                                    <i class='fa fa-repeat'></i>
                                </div>
                                <input type='password' name='password_confirmation' class='form-control'
                                       v-model.trim="$v.password_confirmation.$model" id='password_confirmation' placeholder='Password'>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="!$v.password_confirmation.sameAsPassword && $v.password_confirmation.$dirty"
                        class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'>Passwords must be matches</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="errors.password">
                        <div class='form-control-feedback'>
                    <span class='text-danger align-middle'>
                        <i class='fa fa-close'>{{errors.password | toString() }}</i>
                    </span>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3'></div>
                    <div class='col-md-6'>
                        <button class='btn btn-success'>
                            <i class='fa fa-user-plus'></i>
                            Change password
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</template>
<script>

import {
    required,
    email,
    minLength,
    maxLength,
    sameAs
} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            token: '',
            email: '',
            password: '',
            password_confirmation: '',

            errors: {},
            has_error: false
        };
    },

    validations: {
        email: {
            required,
            email,
            maxLength: maxLength(255)
        },
        password: {
            required,
            minLength: minLength(6),
            maxLength: maxLength(20)
        },
        password_confirmation: {
            sameAsPassword: sameAs('password'),
        }
    },

    beforeMount() {
        this.getEmail();
        this.getToken();
    },

    filters: {
        toString: function (value) {
            return !value ? '' : value.toString();
        }
    },

    methods: {
        submit() {
            this.has_error = false;
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }

            axios.post('auth/reset-password', {
                token: this.token,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation
            })
            .then(response => {
                alert('Password was successfully changed')
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

        getEmail() {
            this.email = this.$route.query.email;
        },

        getToken() {
            this.token = this.$route.params.token;
        }
    },
};

</script>
