<template>
    <div class="container mt-5">
        <a href="#" class="float-right" @click.prevent="$auth.logout()">Logout</a>
        <b-tabs content-class="mt-3">
            <b-tab title="Resume" active>
                <form @submit.prevent="submit">
                    <h1>Profile (Resume)</h1>
                    <div class="row mt-5">
                        <div class="col">
                            <label for="first_name">First name</label>
                            <b-form-input v-model.trim="$v.first_name.$model" id="first_name" placeholder="Enter first name"></b-form-input>
                            <div v-if="!$v.first_name.required && $v.first_name.$dirty"  class="error">First name is required</div>
                            <div v-if="!$v.first_name.minLength && $v.first_name.$dirty" class='error'>Min first name length is 3</div>
                            <div v-if="!$v.first_name.maxLength && $v.first_name.$dirty" class='error'>Max first name length is 30</div>
                        </div>
                        <div class="col">
                            <label for="last_name">Last name</label>
                            <b-form-input v-model.trim="$v.last_name.$model" id="last_name" placeholder="Enter last name"></b-form-input>
                            <div v-if="!$v.last_name.required && $v.last_name.$dirty"  class="error">First name is required</div>
                            <div v-if="!$v.last_name.minLength && $v.last_name.$dirty" class='error'>Min last name length is 3</div>
                            <div v-if="!$v.last_name.maxLength && $v.last_name.$dirty" class='error'>Max last name length is 30</div>
                        </div>
                        <div class="col">
                            <label for="birth_date">Birth date</label>
                            <b-form-input type="date" v-model="data.birth_date" id="birth_date"></b-form-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="country">Country</label>
                                <b-form-select id="country" v-model="country_id">
                                    <option v-for="option in getCountries" :value="option.id">{{ option.name[locale] }}</option>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="city">City</label>
                                <b-form-select id="city" v-model="city_id">
                                    <option v-for="option in getCities" :value="option.id">{{ option.name[locale] }}</option>
                                </b-form-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="address">Address</label>
                            <b-form-input v-model="data.address" id="address" placeholder="Enter address"></b-form-input>
                        </div>
                        <div class="col">
                            <label for="phone">Phone</label>
                            <b-form-input v-model="data.phone" id="phone" placeholder="Enter phone"></b-form-input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="education">Education</label>
                            <b-form-select id="education" v-model="education">
                                <option value="high">High</option>
                                <option value="incomplete higher education">Incomplete higher education</option>
                                <option value="secondary special">Secondary special</option>
                            </b-form-select>
                        </div>
                        <div class="col">
                            <label for="experience">Experience</label>
                            <b-form-select id="experience" v-model="experience_id">
                                <option v-for="option in getExperiences" :value="option.id">{{ option.name[locale] }}</option>
                            </b-form-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="title">Specialization</label>
                            <b-form-input v-model="data.title" id="title" placeholder="Enter specialization"></b-form-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="category">Rubric</label>
                            <b-form-select id="category" v-model="category_id">
                                <option v-for="option in getCategories" :value="option.id">{{ option.name[locale] }}</option>
                            </b-form-select>
                        </div>
                        <div class="col">
                            <label for="desired_salary">Desired salary</label>
                            <b-form-input v-model="data.desired_salary" id="desired_salary" placeholder="Enter desired salary"></b-form-input>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="description">About you (skills etc)</label>
                                <b-form-textarea
                                    id="description"
                                    v-model="data.description"
                                    placeholder="Description"
                                    rows="3"
                                ></b-form-textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="resume">Resume file</label>
                            <b-form-file v-model="resume" id="resume"></b-form-file>
                            <button @click="resume = null" type="button" class="btn btn-dark mt-2 mb-2">Remove resume file</button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </b-tab>
            <b-tab title="Account settings">
                <AccountSettings></AccountSettings>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import { BFormInput, BFormSelect, BFormTextarea, BTabs, BTab, BFormFile } from 'bootstrap-vue'
    import AccountSettings from "../components/blocks/AccountSettings";
    import { required, minLength, maxLength} from "vuelidate/lib/validators";

    export default {
        components: {
            'b-form-input': BFormInput,
            'b-form-textarea': BFormTextarea,
            'b-form-select': BFormSelect,
            'b-tabs': BTabs,
            'b-tab': BTab,
            'b-form-file': BFormFile,
            AccountSettings
        },

        data() {
            return {
                data: {},
                country_id: '',
                first_name: '',
                last_name: '',
                city_id: '',
                education: '',
                experience_id: '',
                category_id: '',
                resume: null,
                locale: this.$i18n.locale
            }
        },

        validations: {
            first_name: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(30)
            },
            last_name: {
                required,
                minLength: minLength(3),
                maxLength: maxLength(30)
            }
        },

        beforeMount() {
            this.$store.dispatch('GET_COUNTRIES');
            this.$store.dispatch('GET_CITIES');
            this.$store.dispatch('GET_EXPERIENCES');
            this.$store.dispatch('GET_CATEGORIES');
            this.getProfile();
        },

        computed: {
            getCountries() {
                return this.$store.getters.countries;
            },
            getCities() {
                return this.$store.getters.cities;
            },
            getExperiences() {
                return this.$store.getters.experiences;
            },
            getCategories() {
                return this.$store.getters.categories;
            }
        },

        methods: {
            getProfile() {
                axios.get('/profiles')
                    .catch(err => {
                        console.log(err)
                    })
                    .then(resp => {
                        this.data = resp.data.data;
                        this.first_name = resp.data.data.first_name;
                        this.last_name = resp.data.data.last_name;
                        this.country_id = resp.data.data.country_id;
                        this.city_id = resp.data.data.city_id;
                        this.birth_date = resp.data.data.birth_date;
                        this.education = resp.data.data.education;
                        this.experience_id = resp.data.data.experience_id;
                        this.category_id = resp.data.data.category_id;
                    });
            },
            submit() {
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return;
                }

                axios.put('/profiles/' + this.data.id, {
                    id: this.data.id,
                    first_name: this.first_name,
                    last_name: this.last_name,
                    address: this.data.address,
                    birth_date: this.data.birth_date,
                    desired_salary: this.data.desired_salary,
                    education: this.education,
                    description: this.data.description,
                    country_id: this.country_id,
                    city_id: this.city_id,
                    experience_id: this.experience_id,
                    category_id: this.category_id,
                    user_id: this.data.user_id,
                    resume: this.resume
                })
                    .then(response => {

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
