<template>
    <div class="login-form">
        <div class="register_page">
            <form class="form-horizontal" @submit.prevent="submit">
                <h2 class="text-center">{{$t('join-us')}}</h2>
                <div class="form-group">
                    <label for="name">{{$t('name')}}</label>
                    <input
                        type="text"
                        v-model="first_name"
                        id="name"
                        name="name"
                        class="form-control"
                        :placeholder="$t('name')"
                        :class="{ 'is-invalid': submitted && $v.first_name.$error }" />
                    <div v-if="submitted && !$v.first_name.required" class="invalid-feedback">{{$t('first-name-is-required')}}</div>
                </div>
                <div class="form-group">
                    <label for="surname">{{$t('surname')}}</label>
                    <input
                        type="text"
                        v-model="last_name"
                        id="surname"
                        name="surname"
                        class="form-control"
                        :placeholder="$t('surname')"
                        :class="{ 'is-invalid': submitted && $v.last_name.$error }" />
                    <div v-if="submitted && !$v.last_name.required" class="invalid-feedback">{{$t('last-name-is-required')}}</div>
                </div>
                <div class="form-group">
                    <label for="email">{{$t('email')}}</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input
                            type="text"
                            v-model="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            :class="{ 'is-invalid': submitted && $v.email.$error }">
                        <div v-if="submitted && !$v.email.required" class="invalid-feedback">{{$t('email-is-required')}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">{{$t('city')}}</label>
                    <div class="input-group input-group-city mb-2 mr-sm-2 mb-sm-0">
                        <!-- <vue-instant
                            :suggestion-attribute="suggestionAttribute"
                            v-model="location.long_name"
                            :disabled="false"
                            @input="changed"
                            @selected="selected"
                            :show-autocomplete="false"
                            :autofocus="true"
                            :suggestions="suggestions"
                            name="customName"
                            :placeholder="$t('city')"
                            type="google">
                        </vue-instant> -->


                        <!-- <vue-instant
                            :suggestOnAllWords="true"
                            :suggestion-attribute="suggestionAttribute"
                            v-model="value" :disabled="false"
                            @input="changed"
                            @click-input="clickInput"
                            @click-button="clickButton"
                            @selected="selected"
                            @enter="enter" @key-up="keyUp"
                            @key-down="keyDown"
                            @key-right="keyRight"
                            @clear="clear" 
                            @escape="escape"
                            :show-autocomplete="true"
                            :autofocus="false"
                            :suggestions="suggestions"
                            name="customName"
                            placeholder="custom placeholder"
                            type="google">
                        </vue-instant> -->
                        <!-- <v-select
                            label="name"
                            v-model="selected"
                            :options="options"
                            @search="onSearch">
                            <template slot="no-options">
                                    type to search GitHub repositories..
                                </template>
                                <template slot="option" slot-scope="option">
                                    <div class="d-center">
                                        <img :src='option.owner.avatar_url'/> 
                                        {{ option.full_name }}
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <div class="selected d-center">
                                        <img :src='option.owner.avatar_url'/> 
                                        {{ option.full_name }}
                                    </div>
                                </template>
                        </v-select> -->
                        <input
                            v-model="location.long_name"
                            class="form-control"
                            @input="changed"
                            :placeholder="$t('city')"
                            type="text"/>
                        <select
                            v-model="location.long_name"
                            :suggestions="suggestions">
                            <option
                                v-for="(item, index) in suggestions"
                                :key="index"
                                :value="suggestions.long_name" selected>
                                    {{ item.long_name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">{{$t('phone')}}</label>
                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                        <input
                            type="tel"
                            v-model="phone"
                            class="form-control"
                            id="phone"
                            :placeholder="$t('phone')"
                            :class="{ 'is-invalid': submitted && $v.email.$error }"/>
                        <div v-if="submitted && !$v.phone.required" class="invalid-feedback">{{$t('phone-is-required')}}</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">{{$t('password')}}</label>
                    <input
                        type="password"
                        v-model="password"
                        id="password" name="password"
                        class="form-control"
                        :placeholder="$t('password')"
                        :class="{ 'is-invalid': submitted && $v.password.$error }" />
                    <div v-if="submitted && $v.password.$error" class="invalid-feedback">
                        <span v-if="!$v.password.required">{{$t('password-is-required')}}</span>
                        <span v-if="!$v.password.minLength">{{$t('password-must-contain')}}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{$t('password-confirmation')}}</label>
                    <input
                        type="password"
                        v-model="password_confirmation"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        :placeholder="$t('password-confirmation')"
                        :class="{ 'is-invalid': submitted && $v.password_confirmation.$error }" />
                    <div v-if="submitted && $v.password_confirmation.$error" class="invalid-feedback">
                        <span v-if="!$v.password_confirmation.required">{{$t('confirm-password-is-required')}}</span>
                        <span v-else-if="!$v.password_confirmation.sameAsPassword">{{$t('passwords-must-match')}}</span>
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
import vSelect from 'vue-select'

export default {
    components: {
        LoginWithGoogle,
        LoginWithFacebook,
        vSelect
    },
    data() {
        return {
            value: '',
            locale: null,
            error_dialog: false,
            alert_dialog: false,
            role: null,
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            location: {
                name: '',
                long_name: '',
                place_id: '',
                lat: '',
                lng: ''
            },
            password: '',
            password_confirmation: '',
            errors: {},
            user_exists: false,
            has_error: false,
            suggestionAttribute: 'long_name',
            suggestions: [],
            submitted: false,

            options: [],
            selectedEvent: "",
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
        location: {
            required
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
        this.locale = this.$store.getters.locale;
        this.$i18n.locale = this.locale;
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            this.search(loading, search, this);
        },
        selected: function() {
            this.selectedEvent = 'selection changed'
        },
        // onChange(event) {
        //     console.log(event.target.value);
        // },
        selected: function(i) {
          console.log(i, 'selected')
        },
        submit() {
            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            }
            //this.show_spiner = true;
            this.has_error = false;
            this.$auth.register({
                data: {
                    first_name: this.first_name,
                    last_name: this.last_name,
                    email: this.email,
                    location: {
                        name: this.location.name,
                        long_name: this.location.long_name,
                        place_id: this.location.place_id,
                        lat: this.location.lat,
                        lng: this.location.lng
                    },
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
        changed: function () {
            axios.get('/location/get-geo?query=' + this.location.long_name + '&locale=' + this.locale)    
                .then((response) => {
                    response.data.data.forEach((result) => {
                        this.location.name = result.name;
                        this.location.long_name = result.long_name;
                        this.location.place_id = result.place_id;
                        this.location.lat = result.lat.toString();
                        this.location.lng = result.lng.toString();
                        this.suggestions.push(result)
                        console.log(result)
                    })
                })
        }
    },
    filters: {
        toString: function (value) {
            if (!value) return '';
            return value.toString();
        }
    }
};
</script>

<style lang="scss">
.register_page {
    padding-top: 58px;
}
</style>
