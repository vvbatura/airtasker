<template>
    <div class="login-form">
        <form class="reset-form" @submit.prevent="submit">
            <h2 class="text-center mb-4">Forgot password ?</h2>
            <p class="notice_reset">Enter your email or phone below and we will send you instructions
            on how to reset your password</p>
            <div class="form-group">
                <button type="button" class="btn btn_reset btn-lg btn-block" @click="fromEmail">from Email</button>
                <button type="button" class="btn btn_reset btn-lg btn-block" @click="fromPhone">from Phone</button>
            </div>
            <div class="form-group" v-show="isEmail">
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
            <div class="form-group" v-show="isPhone">
                <div class="input-group">
                    <input
                    type="text" v-model="$v.phone.$model" @keyup="has_error = false"
                    class="form-control" name="phone" placeholder="Enter your Phone"/>
                </div>
                <span v-if="!$v.phone.required && $v.$dirty" class="text-danger">Phone is required</span>
                <span v-if="!$v.phone.maxLength && $v.phone.$dirty" class="text-danger">Max phone length is 255</span>
                <span v-if="has_error && $v.phone.$dirty && !$v.phone.$invalid" class="text-danger">Phone not found</span>
            </div>
            <div class="d-flex justify-content-between">
                <router-link class="frg_btn cancel_btn" :to="{name: 'login'}">Cancel</router-link>
                <button type="submit" class="btn btn-lg frg_btn">Send</button>
            </div>
        </form>
    </div>
</template>

<script>
import { required, email, maxLength } from 'vuelidate/lib/validators';
import {openWindow} from "../../common/module/helper";

export default {
    data: function () {
        return {
            error_dialog: false,
            dialog: false,
            email: '',
            phone: '',
            has_error: false,
            isEmail: false,
            isPhone: false,
        };
    },

    validations: {
        email: {
            required,
            email,
            maxLength: maxLength(255)
        },
        phone: {
            required,
            maxLength: maxLength(255)
        }
    },

    methods: {
        fromEmail() {
            this.isPhone = false;
            this.isEmail = true;
        },
        fromPhone() {
            this.isEmail = false;
            this.isPhone = true;
        },
        submit() {
            if (this.$v.$invalid) {
                //return;
            }

            this.has_error = false;

            if (this.isEmail && this.email) {
                axios
                    .post('auth/forgot-password-email', {
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
            } else {
                axios
                    .post('auth/forgot-password-phone', {
                        phone: this.phone
                    })
                    .then(response => {
                        alert('Check your phone')
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
            }

        },
    }
};
</script>

<style lang="scss">
.reset-form {
    max-width: 500px;
    margin: 0 auto;
}
.notice_reset {
    margin-bottom: 30px;
}
.frg_btn {
    width: 48%;
    margin: 0 !important;
}
.cancel_btn {
    color: rgb(0, 143, 180);
    text-align: center;
    line-height: 45px;
    border: 1px solid rgb(231, 235, 251);
    border-radius: 45px;
    &:hover {
        text-decoration: none;
    }
}
</style>
