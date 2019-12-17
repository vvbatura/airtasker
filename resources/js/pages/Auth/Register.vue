<template>
    <div class="login-form">
        <form class="form-horizontal" @submit.prevent="submit">
            <h2 class="text-center">{{$t('join-us')}}</h2>
            <div class="form-group">
                <label for="first_name">{{$t('name')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input v-model="$v.first_name.$model" type="text" class="form-control" id="first_name" :placeholder="$t('name')" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="last_name">{{$t('surname')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input v-model="$v.last_name.$model" type="text" class="form-control" id="last_name" :placeholder="$t('surname')" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="email">{{$t('email')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input type="text" v-model="$v.email.$model" class="form-control" id="email"
                            placeholder="you@example.com" required autofocus>
                </div>
            </div>
            <div class="form-group">
                <label for="email">{{$t('phone')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input type="tel" v-mask="'(+499) 999 99 99'" v-model="$v.phone.$model" class="form-control" id="phone"
                            :placeholder="$t('phone')" required autofocus/>
                </div>
            </div>
            <div class="form-group has-danger">
                <label for="password">{{$t('password')}}</label>
                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                    <input type="password" v-model.trim="$v.password.$model" class="form-control" id="password" :placeholder="$t('password')" required>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-lg">{{$t('join-airtasker')}}</button>
                <div class="login_with text-center">
                    <span>{{$t('or-sign-up-with')}}</span>
                </div>
                <div class="d-flex justify-content-between btn_media">
                    <login-with-facebook />
                    <login-with-google />
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-between">
            <p>{{$t('already-have')}}</p>
            <router-link :to="{ name: 'login'}">
                {{$t('login')}}
            </router-link>
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
import LoginWithGoogle from "../../components/social/google";
import LoginWithFacebook from "../../components/social/facebook";

export default {
    components: {
        LoginWithGoogle,
        LoginWithFacebook
    },
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
