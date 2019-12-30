<template>
    <div class="login-form log_own">
        <form v-on:submit.prevent="submit" autocomplete="off">
            <h2 class="text-center mb-4">{{$t('login')}}</h2>
            <div class="form-group">
                <label for="email-login">{{$t('email')}}</label>
                <input
                    v-model="email"
                    id="email-login"
                    type="email"
                    class="form-control"
                    :placeholder="$t('email')"
                    :class="{ 'is-invalid': submitted && $v.email.$error }">
                <div v-if="submitted && !$v.email.required" class="invalid-feedback">{{$t('email-is-required')}}</div>
                <div v-if="!$v.email.email && $v.email.$dirty" class="not-valid invalid-feedback">{{$t('incorrect-email')}}</div>
                <div v-if="!$v.email.maxLength && $v.email.$dirty" class="not-valid invalid-feedback">{{$t('max-email-length-is-255')}}</div>
            </div>
            <div class="form-group">
                <label for="password-login">{{$t('password')}}</label>
                <input
                    type="password"
                    v-model="password"
                    id="password"
                    name="password"
                    class="form-control"
                    :placeholder="$t('password')"
                    :class="{ 'is-invalid': submitted && $v.password.$error }" />
                <div v-if="submitted && $v.password.$error" class="invalid-feedback">
                    {{$t('password-is-required')}}
                </div>
                <div v-if="!$v.password.minLength && $v.$dirty && !$v.email.$invalid" class="not-valid">
                    {{$t('min-password-length-is-6')}}
                </div>
                <div v-if="!$v.password.maxLength && $v.$dirty && !$v.email.$invalid" class="not-valid">
                    {{$t('max-password-length-is-255')}}
                </div>
                <div v-if="has_error" class="not-valid">{{$t('login-details-are-incorrect')}}</div>
            </div>
            <div class="forget_btn">
                <router-link :to="{name: 'forgot'}" class="pull-right">{{$t('forgot-password')}}</router-link>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-lg">{{$t('login')}}</button>
                <div class="login_with text-center">
                    <span>{{$t('or-login-with')}}</span>
                </div>
                <div class="d-flex justify-content-between btn_media">
                    <login-with-facebook />
                    <login-with-google />
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-between">
            <p>{{$t('dont-have')}}</p>
            <router-link :to="{ name: 'register'}">
                {{$t('sign_up')}}
            </router-link>
        </div>
    </div>
</template>

<script>
import {
    required,
    email,
    minLength,
    maxLength
} from "vuelidate/lib/validators";
import LoginWithGoogle from "../../components/social/google";
import LoginWithFacebook from "../../components/social/facebook";

export default {
    components: {LoginWithGoogle, LoginWithFacebook},
    data() {
        return {
            error_dialog: false,
            email: null,
            password: null,
            remember_me: false,
            has_error: false,
            errors: null,
            locale: null,
            submitted: false
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
            maxLength: maxLength(255)
        }
    },
    beforeMount() {
        this.locale = this.$store.getters.locale
    },
    methods: {
        submit() {
            this.submitted = true;

            this.has_error = false;
            
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            this.errors = null;

            this.$auth.login({
                data: {
                    locale: this.locale,
                    email: this.email,
                    password: this.password,
                    remember_me: this.remember_me,
                },
                success: function() {
                    //this.$store.dispatch('setLocale', {locale: this.locale});
                },
                error: function(error) {
                    switch (error.response.status) {
                        case 422:
                        case 400:
                            this.has_error = true;
                            this.errors = error.response.data;
                            break;
                        case 423:
                            app.has_error = true;
                            this.errors = error.response.data;
                            break;
                        default:
                            this.error_dialog = true;
                            break;
                    }
                },
                rememberMe: true,
            });
        },
        changeLocale() {
            this.$i18n.locale = this.locale;
        },
    }

}
</script>

<style lang="scss">
.login-form {
    width: 400px;
    margin: 0 auto;
    padding: 20px 20px 30px 20px;
    border-radius: 5px;
    background: #ffffff;
}
.log_own {
    transform: translateY(-58px);
}
@media (max-width: 560px) {
    .login-form {
        max-width: 100%;
        width: 100vw;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        flex-direction: column;
    }
}
.forget_btn {
    text-align: right;
    margin-bottom: 20px;
    a {
        font-size: 20px;
    }
}
.btn-lg {
    background: rgb(125, 179, 67);
    color: #ffffff;
    height: 45px;
    border-radius: 45px;
    margin-bottom: 15px;
    &:hover {
        color: #ffffff;
    }
}
.login_with {
    margin-bottom: 15px;
    font-size: 16px;
    color: rgb(84, 90, 119);
    position: relative;
    span {
        background: #ffffff;
        position: relative;
        z-index: 10;
        padding: 0 15px;
    }
    &:after {
        content: '';
        display: block;
        position: absolute;
        background: rgb(187, 194, 220);
        height: 1px;
        width: 100%;
        top: 55%;
        left: 0;
        transform: translateY(-50%);
    }
}
</style>
