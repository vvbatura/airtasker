<template>
    <div class="login-form">
        <form class="reset-form" @submit.prevent="submit">
            <h2 class="text-center mb-4">{{$t('forgot-password')}}</h2>
            <p class="notice_reset">{{$t('enter-your-email-phone')}}</p>
            <div class="text-danger mb-2">{{ message }}</div>
            <div class="form-group">
                <button type="button" class="btn btn_reset btn-lg btn-block" @click="fromEmail">{{$t('from-email')}}</button>
                <button type="button" class="btn btn_reset btn-lg btn-block" @click="fromPhone">{{$t('from-phone')}}</button>
            </div>
            <div class="form-group" v-show="isEmail">
                <div class="input-group">
                    <input
                        type="text"
                        v-model="email"
                        class="form-control"
                        name="email"
                        :placeholder="$t('enter-your-email')"
                        :class="{ 'is-invalid': submitted && $v.email.$error }"/>
                </div>
                <span v-if="!$v.email.required && $v.$dirty" class="text-danger">{{$t('email-is-required')}}</span>
                <span v-if="!$v.email.email && $v.email.$dirty" class="text-danger">{{$t('email-not-found')}}</span>
                <span v-if="!$v.email.maxLength && $v.email.$dirty" class="text-danger">{{$t('max-email-length-is-255')}}</span>
                <span v-if="has_error && $v.email.$dirty && !$v.email.$invalid" class="text-danger">{{$t('email-not-found')}}</span>
            </div>
            <div class="form-group" v-show="isPhone">
                <div class="input-group">
                    <input
                        type="text"
                        v-model="phone"
                        class="form-control"
                        name="phone"
                        :placeholder="$t('enter-your-phone')"
                        :class="{ 'is-invalid': submitted && $v.phone.$error }"/>
                </div>
                <span v-if="!$v.phone.required && $v.$dirty" class="text-danger">{{$t('phone-is-required')}}</span>
                <span v-if="!$v.phone.maxLength && $v.phone.$dirty" class="text-danger">{{$t('max-phone-length-is-255')}}</span>
                <span v-if="has_error && $v.phone.$dirty && !$v.phone.$invalid" class="text-danger">{{$t('phone-not-found')}}</span>
            </div>
            <div class="d-flex justify-content-between">
                <router-link class="frg_btn cancel_btn" :to="{name: 'login'}">{{$t('cancel')}}</router-link>
                <button type="submit" class="btn btn-lg frg_btn">{{$t('send')}}</button>
            </div>
        </form>
        <div>
            <b-modal ref="my-modal" no-close-on-backdrop hide-header hide-footer> 
                <div class="d-block text-center">
                    <h3 class="mb-0">Your email was checked!</h3>
                    <router-link class="custom_close" to="/login">
                        <i class="ri-close-line"></i>
                    </router-link>
                </div>
            </b-modal>
        </div>
    </div>
</template>

<script>
import { required, email, maxLength } from 'vuelidate/lib/validators';
import {openWindow} from "../../common/module/helper";
import { BFormCheckbox, BButton, BModal, BForm, BFormGroup, BFormInput, BFormTextarea, BListGroup, BListGroupItem  } from 'bootstrap-vue'

export default {
    components: {
        'b-form-checkbox': BFormCheckbox,
        'b-button': BButton,
        'b-modal': BModal,
        'b-form': BForm,
        'b-form-group': BFormGroup,
        'b-form-input': BFormInput,
        'b-form-textarea': BFormTextarea,
        'b-list-group' : BListGroup,
        'b-list-group-item' : BListGroupItem
    },
    data: function () {
        return {
            error_dialog: false,
            dialog: false,
            email: '',
            phone: '',
            has_error: false,
            isEmail: false,
            isPhone: false,
            modalShow: true,
            submitted: false,
            message: ''
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
            this.submitted = true;

            this.$v.$touch();
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
                        this.$refs['my-modal'].show()
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
                        this.$router.push('confirm-phone') 
                    })
                    .catch(error => {
                        switch (error.response.status) {
                            case 422:
                                this.has_error = true;
                                this.message = "Fill one of the field!"
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
.custom_close {
    text-decoration: none;
    color: #000000;
    position: absolute;
    top: 0;
    right: 0;
    width: 30px;
    height: 30px;
    &:hover {
        text-decoration: none;
    }
}
</style>
