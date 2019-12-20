<template>
    <div class="login-form">
        <form @submit.prevent="handleSubmit" autocomplete="off">
            <h2 class="text-center mb-4">Check SMS</h2>
            <div class="form-group">
                <p>{{message}}</p>
            </div>
            <div class="form-group">
                <label for="code">{{$t('enter-code')}}</label>
                <input
                    type="text"
                    v-model="user.code"
                    id="code"
                    name="code"
                    class="form-control"
                    :placeholder="$t('enter-code')"
                    :class="{ 'is-invalid': submitted && $v.user.code.$error }" />
                <div v-if="submitted && !$v.user.code.required" class="invalid-feedback">Code is required</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    v-model="user.password"
                    id="password" name="password"
                    class="form-control"
                    :placeholder="$t('password')"
                    :class="{ 'is-invalid': submitted && $v.user.password.$error }" />
                <div v-if="submitted && $v.user.password.$error" class="invalid-feedback">
                    <span v-if="!$v.user.password.required">Password is required</span>
                    <span v-if="!$v.user.password.minLength">Password must be at least 6 characters</span>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">{{$t('password-confirmation')}}</label>
                <input
                    type="password"
                    v-model="user.confirmPassword"
                    id="confirmPassword"
                    name="confirmPassword"
                    class="form-control"
                    :placeholder="$t('password-confirmation')"
                    :class="{ 'is-invalid': submitted && $v.user.confirmPassword.$error }" />
                <div v-if="submitted && $v.user.confirmPassword.$error" class="invalid-feedback">
                    <span v-if="!$v.user.confirmPassword.required">{{$t('confirm-password-is-required')}}</span>
                    <span v-else-if="!$v.user.confirmPassword.sameAsPassword">{{$t('passwords-must-match')}}</span>
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
import {maxLength, minLength, required, sameAs} from "vuelidate/lib/validators";

export default {
    data() {
        return {
            message: '',
            user: {
                code: "",
                password: "",
                confirmPassword: ""
            },
            submitted: false
        };
    },
    validations: {
        code: {
            required
        },
        user: {
            code: { required },
            password: { required, minLength: minLength(6) },
            confirmPassword: { required, sameAsPassword: sameAs('password') }
        }
    },
    methods: {
        handleSubmit(e) {
            this.submitted = true;

            // stop here if form is invalid
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }

            alert("SUCCESS!! :-)\n\n" + JSON.stringify(this.user));
        },

        // submit() {
        //     axios.get('/auth/reset-password', {
        //         params: {
        //             token: this.code,
        //             password: this.password,
        //             password_confirmation: this.password_confirmation
        //         }
        //     })
        //     .then(response => {
        //             this.message = 'Successfully You verified phone.';
        //         }
        //     )
        //     .catch(error => {
        //             switch (error.response.status) {
        //                 case 400:  //not valid token
        //                     this.message = 'Not valid token';
        //                     break;
        //                 case 409:   //conflict, unknown problem
        //                     this.message = 'Conflict, unknown problem';
        //                     break;
        //                 case 422:   //not the same password
        //                     this.message = 'Not the same password';
        //                     break;
        //                 default:
        //                     this.error_dialog = true;
        //                     break;
        //             }
        //         }
        //     )
        // }
    }
}
</script>


<style scoped>

</style>