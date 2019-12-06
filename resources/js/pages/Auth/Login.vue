<template>
    <div class="login-form">
        <form v-on:submit.prevent="submit">
            <h2 class="text-center mb-5">Log in</h2>
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" v-model.trim="$v.email.$model">
                <div v-if="!$v.email.required && $v.email.$dirty" class="not-valid">Email is required</div>
                <div v-if="!$v.email.email && $v.email.$dirty" class="not-valid">Incorrect email</div>
                <div v-if="!$v.email.maxLength && $v.email.$dirty" class="not-valid">Max email length is 255</div>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" v-model="$v.password.$model">
                <div
                    v-if="!$v.password.required && $v.$dirty && !$v.email.$invalid"
                    class="not-valid"
                >Password is required</div>
                <div
                    v-if="!$v.password.minLength && $v.$dirty && !$v.email.$invalid"
                    class="not-valid"
                >Min Password length is 6</div>
                <div
                    v-if="!$v.password.maxLength && $v.$dirty && !$v.email.$invalid"
                    class="not-valid"
                >Max Password length is 255</div>
                <div v-if="has_error" class="not-valid">Login details are incorrect</div>
            </div>
            <div class="form-group">
                <select class="form-control" v-model="locale" v-on:change="changeLocale">
                    <option :value="languages.uk">Укораїнська</option>
                    <option :value="languages.ru">Русский</option>
                    <option :value="languages.en" selected>English</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg">{{$t('login')}}</button>
                <login-with-google />
            </div>
            <div class="clearfix">
                <label class="pull-left checkbox-inline"><input type="checkbox" v-model="remember_me"> {{$t('remember_me')}}</label>
                <router-link :to="{name: 'forgot'}" class="pull-right">{{$t('forgot_password')}}</router-link>
            </div>
        </form>
        <p class="text-center">
            <router-link :to="{ name: 'register'}">
                {{$t('create_account')}}
            </router-link>
        </p>
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

    export default {
        components: {LoginWithGoogle},
        data() {
            return {
                error_dialog: false,
                email: null,
                password: null,
                remember_me: false,
                has_error: false,
                errors: null,
                locale: null,
                languages: {en: this.$i18n.locale, ru: this.$i18n.fallbackLocale, uk: 'uk'}
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
                this.has_error = false;
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }
                this.errors = null;

                this.$auth.login({
                    data: {
                        email: this.email,
                        password: this.password,
                        remember_me: this.remember_me,
                        locale: this.locale
                    },
                    success: function() {
                        this.$store.dispatch('setLocale', {locale: this.locale});
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
            }
        }

    }
</script>

<style scoped lang="scss">
    .login-form {
        max-width: 500px;
        margin: 0 auto;
    }
</style>
