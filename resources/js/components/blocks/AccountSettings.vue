<template>
    <form @submit.prevent="submit">
        <h1>Account settings</h1>
        <div class="row">
            <div class="col">
                <b-form-group label="Notification">
                    <b-form-checkbox-group
                        id="notification"
                        v-model="selected"
                        :options="options"
                        name=""
                    ></b-form-checkbox-group>
                </b-form-group>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <label for="email">Email</label>
                <b-form-input v-model.trim="$v.email.$model" id="email" placeholder="Enter email" :class="{'is-invalid': $v.email.$invalid}"></b-form-input>
                <div v-if="!$v.email.required && $v.email.$dirty"  class="error">Email is required</div>
                <div v-if="!$v.email.email && $v.email.$dirty"  class="error">Incorrect email</div>
            </div>
            <div class="col">
                <label for="name">Account name</label>
                <b-form-input v-model.trim="$v.name.$model" id="name" placeholder="Enter account name" :class="{'is-invalid': $v.name.$invalid}"></b-form-input>
                <div v-if="!$v.name.required && $v.name.$dirty"  class="error">Name is required</div>
                <div v-if="!$v.name.minLength && $v.name.$dirty" class='error'>Min name length is 3</div>
                <div v-if="!$v.name.maxLength && $v.name.$dirty" class='error'>Max name length is 30</div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="password">Old password</label>
                <b-form-input type="password" v-model.trim="$v.current_password.$model" id="password" placeholder="Old password"></b-form-input>
                <div v-if="!$v.current_password.minLength && $v.current_password.$dirty" class='error'>Min password length is 3</div>
                <div v-if="!$v.current_password.maxLength && $v.current_password.$dirty" class='error'>Max password length is 30</div>
            </div>
            <div class="col">
                <label for="new_password">New password</label>
                <b-form-input type="password" v-model.trim="$v.password.$model" id="new_password" placeholder="New password"></b-form-input>
                <div v-if="!$v.password.minLength && $v.password.$dirty" class='error'>Min password length is 3</div>
                <div v-if="!$v.password.maxLength && $v.password.$dirty" class='error'>Max password length is 30</div>
            </div>
            <div class="col">
                <label for="password_confirmation">Password confirmation</label>
                <b-form-input type="password" v-model.trim="$v.password_confirmation.$model" id="password_confirmation" placeholder="Password confirmation"></b-form-input>
                <div v-if="!$v.password_confirmation.sameAsPassword && $v.password_confirmation.$dirty" class="error">Password must be matches</div>
            </div>
            <div class="col d-flex align-items-end">
                <button type="button" class="btn btn-info" @click="changePassword" :disabled=!current_password>Change password</button>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">Save</button>
    </form>
</template>

<script>
    import { BFormInput, BFormGroup, BFormCheckboxGroup } from 'bootstrap-vue'
    import { required, minLength, maxLength, email, sameAs } from "vuelidate/lib/validators";

    export default {
        components: {
            'b-form-input': BFormInput,
            'b-form-group': BFormGroup,
            'b-form-checkbox-group': BFormCheckboxGroup,
        },

        data() {
            return {
                email: '',
                name: '',
                password: '',
                current_password: '',
                password_confirmation: '',
                selected: [],
                options: [
                    {text: 'New vacancies', value: 1},
                    {text: 'Private messages', value: 2},
                    {text: 'Email notification', value: 3},
                    {text: 'Other', value: 4}
                ]
            }
        },

        validations: {
            name: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(255)
            },
            email: {
                required,
                email,
                maxLength: maxLength(255)
            },
            password: {
                minLength: minLength(6),
                maxLength: maxLength(20)
            },
            current_password: {
                minLength: minLength(6),
                maxLength: maxLength(20)
            },
            password_confirmation: {
                sameAsPassword: sameAs('password'),
            }
        },

        mounted() {
            this.email = this.$auth.user().email;
            this.name = this.$auth.user().name;
        },

        methods: {
            submit() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }

                axios.post('/users', {
                    name: this.name,
                    email: this.email,
                    id: this.$auth.user().id
                })
                .then(response => {

                })
                .catch(error => {
                    console.log(error)
                })
            },
            changePassword() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }

                axios.post('/users/password', {
                    current_password: this.current_password,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>

</style>
