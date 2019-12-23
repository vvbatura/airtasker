<template>
    <div class="login-form">
        <form v-if="formShow" class="form-horizontal" role="form" @submit.prevent="submit">
            <h2 class="text-center mb-4">{{$t('change-password')}}</h2>
            <div class="form-group has-danger">
                <label for="password">{{$t('password')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input
                        type="password"
                        v-model.trim="password"
                        class="form-control"
                        id="password"
                        :placeholder="$t('password')"
                        :class="{ 'is-invalid': submitted && $v.password.$error }" >
                    <div v-if="submitted && $v.password.$error" class="invalid-feedback">
                        <span v-if="!$v.password.required">{{$t('password-is-required')}}</span>
                        <span v-if="!$v.password.minLength">{{$t('password-must-contain')}}</span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{$t('confirm-password')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        v-model.trim="$v.password_confirmation.$model"
                        id="password_confirmation"
                        placeholder="Password">
                </div>
                <div v-if="!$v.password_confirmation.sameAsPassword && $v.password_confirmation.$dirty">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle">
                            {{$t('passwords-must-match')}}
                        </span>
                    </div>
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
        <div class="text-center" v-else>
            <h2 class="text-center mb-3">{{ message }}</h2>
            <router-link class="btn-lg link_login" to="/login">{{$t('return-to-login')}}</router-link>
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
            message: '',
            token: '',
            password: '',
            password_confirmation: '',
            formShow: true,
            //currentRoute: window.location.hostname,

            errors: {},
            has_error: false,

            submitted: false
        };
    },
    validations: {
        password: {
            required,
            minLength: minLength(6),
            maxLength: maxLength(20)
        },
        password_confirmation: {
            sameAsPassword: sameAs('password'),
        }
    },
    created() {
        axios.post('/auth/check-token', {
            token: this.$route.params.token
        })
        .then(response => {
                console.log("check")
            }
        )
        .catch(error => {
                this.formShow = false;
                switch (error.response.status) {
                    case 400:  //not valid token
                        this.message = 'Not valid token';
                        break;
                    case 409:   //conflict, unknown problem
                        this.message = 'Conflict, unknown problem';
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
        this.getToken();
    },
    filters: {
        toString: function (value) {
            return !value ? '' : value.toString();
        }
    },
    methods: {
        submit() {
            this.submitted = true;

            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }

            this.has_error = false;

            axios.post('auth/reset-password', {
                token: this.token,
                password: this.password,
                password_confirmation: this.password_confirmation
            })
            .then(response => {
                this.router(window.location.href = '/login')
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
        getToken() {
            this.token = this.$route.params.token;
        }
    },
};

</script>
