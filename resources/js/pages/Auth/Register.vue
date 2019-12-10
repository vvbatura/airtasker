<template>
    <div class="row mb-5 mt-lg-5 text-center">
        <div class="col">
            <form class='form-horizontal' role='form' @submit.prevent="submit">
                <div class='row'>
                    <div class='col-md-3'></div>
                    <div class='col-md-6'>
                        <h2>Register New User</h2>
                        <hr>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='first_name'>First Name</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'><i class='fa fa-user'></i></div>
                                <input v-model="$v.first_name.$model" type='text' class='form-control' id='first_name' placeholder='First Name' required autofocus>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.first_name.required && $v.first_name.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                        <span class='text-danger align-middle'>
                            <i class='fa fa-close'> First Name is required</i>
                        </span>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="errors.first_name && has_error">
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'>{{errors.first_name | toString() }}</i>
                            </span>
                        </div>
                    </div>
                    <div v-if="!$v.first_name.maxLength && $v.first_name.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> First Name must contain at less 150</i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='last_name'>Last Name</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'><i class='fa fa-user'></i></div>
                                <input v-model="$v.last_name.$model" type='text' class='form-control' id='last_name' placeholder='Last Name' required autofocus>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.last_name.required && $v.last_name.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Last Name is required</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="errors.last_name && has_error">
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'>{{errors.last_name | toString() }}</i>
                            </span>
                        </div>
                    </div>
                    <div v-if="!$v.last_name.maxLength && $v.last_name.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Last Name must contain at less 150</i>
                            </span>
                        </div>
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
                                       placeholder='you@example.com' required autofocus>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.email.required && $v.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Email is required</i>
                            </span>
                        </div>
                    </div>
                    <div v-if="!$v.email.email && $v.$dirty" class='col-md-3'>
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
                    <div v-if="!$v.email.maxLength && $v.email.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Email must contain at less 150</i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-3 field-label-responsive'>
                        <label for='email'>Phone Number</label>
                    </div>
                    <div class='col-md-6'>
                        <div class='form-group'>
                            <div class='input-group mb-2 mr-sm-2 mb-sm-0'>
                                <div class='input-group-addon' style='width: 2.6rem'><i class='fa fa-at'></i></div>
                                <input type='text' v-model="$v.phone.$model" class='form-control' id='phone'
                                       placeholder='0981234567' required autofocus>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.phone.required && $v.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Phone is required</i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3" v-if="errors.phone && has_error">
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'>{{errors.phone | toString() }}</i>
                            </span>
                        </div>
                    </div>
                    <div v-if="!$v.phone.maxLength && $v.phone.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Phone must contain at less 150</i>
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
                                <input type='password' v-model.trim="$v.password.$model" class='form-control' id='password' placeholder='Password' required>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.password.required && $v.password.$dirty" class='col-md-3'>
                        <div class='form-control-feedback'>
                            <span class='text-danger align-middle'>
                                <i class='fa fa-close'> Password is required</i>
                            </span>
                        </div>
                    </div>
                    <div v-if="!$v.password.minLength && $v.password_confirmation.$dirty || !$v.password.maxLength && $v.password_confirmation.$dirty" class='col-md-3'>
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
                                       v-model.trim="$v.password_confirmation.$model" id='password_confirmation' placeholder='Password' required>
                            </div>
                        </div>
                    </div>
                    <div v-if="!$v.password_confirmation.sameAsPassword && $v.password_confirmation.$dirty" class='col-md-3'>
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
                            Register
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
            error_dialog: false,
            alert_dialog: false,

            role: null,

            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            password: '',
            password_confirmation: '',

            errors: {},
            user_exists: false,
            has_error: false
        };
    },

    validations: {
        first_name: {
            required,
            maxLength: maxLength(150)
        },
        last_name: {
            required,
            maxLength: maxLength(150)
        },
        email: {
            required,
            email,
            maxLength: maxLength(150)
        },
        phone: {
            required,
            maxLength: maxLength(150)
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

    methods: {
        submit() {
            this.show_spiner = true;
            this.has_error = false;

            this.$auth.register({
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    phone: this.phone,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                },
                success: function () {
                    this.show_spiner = true;
                },
                error: function (error) {
                    switch (error.response.status) {
                        case 422:
                            this.errors_validations_popup_modal_show = true;
                            this.errors = error.response.data.errors;
                            this.has_error = true;
                            break;
                        case 423:
                            this.alert_dialog = true;
                            break;
                        default:
                            this.error_dialog = true;
                            break;
                    }
                },
                redirect: 'login'
            });
        },
    },

    filters: {
        toString: function (value) {
            if (!value) return '';
            return value.toString();
        }
    }
};

</script>
