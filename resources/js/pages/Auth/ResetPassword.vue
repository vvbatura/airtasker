<template>
    <div class="login-form">
        <form class="form-horizontal" role="form" @submit.prevent="submit">
            <h2 class="text-center mb-4">Change password</h2>
                <!-- <div class="form-group">
                    <label for="email">E-Mail Address</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input
                            type="text"
                            v-model="$v.email.$model"
                            class="form-control"
                            id="email"
                            placeholder="you@example.com"
                            autofocus autocomplete="off">
                    </div>
                </div> -->
                <div v-if="!$v.email.required && $v.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            Email is required
                        </span>
                    </div>
                </div>
                <div v-if="!$v.email.email && $v.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            Email must be email
                        </span>
                    </div>
                </div>
                <div v-if="errors.email && has_error">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            {{errors.email | toString() }}
                        </span>
                    </div>
                </div>
                <div class="form-group has-danger">
                    <label for="password">Password</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input
                            type="password"
                            v-model.trim="$v.password.$model"
                            class="form-control"
                            id="password"
                            placeholder="Password">
                    </div>
                </div>
                <div v-if="!$v.password.required && $v.password.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            Password is required
                        </span>
                    </div>
                </div>
                <div v-if="!$v.password.minLength && $v.password_confirmation.$dirty || !$v.password.maxLength && $v.password_confirmation.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            Password must contain at least 6 characters and less 20
                        </span>
                    </div>
                </div>
                <div class="field-label-responsive">
                    <label for="password_confirmation">Confirm Password</label>
                </div>
                <div class="form-group">
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            v-model.trim="$v.password_confirmation.$model"
                            id="password_confirmation"
                            placeholder="Password">
                    </div>
                </div>
                <div v-if="!$v.password_confirmation.sameAsPassword && $v.password_confirmation.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            {{$t('passwords-must-match')}}
                        </span>
                    </div>
                </div>
                <div v-if="errors.password">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                           {{errors.password | toString() }}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <router-link class="frg_btn cancel_btn" :to="{name: 'login'}">{{$t('cancel')}}</router-link>
                    <button type="submit" class="btn btn-lg frg_btn">{{$t('send')}}</button>
                </div>
        </form>
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
            //email: '',
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
