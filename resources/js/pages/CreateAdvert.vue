<template>
    <div class="container mt-5">
        <h2>{{$t('add-advert')}}</h2>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" href="#speed-advert" aria-controls="home" role="tab" data-toggle="tab">{{$t('speed-advert')}}</a></li>
            <li class="nav-item"><a class="nav-link" href="#extended-advert" aria-controls="about" role="tab" data-toggle="tab">{{$t('extended-advert')}}</a></li>
        </ul>

        <div class="card pmd-card">
            <div class="card-body">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tablist" aria-labelledby="home-tab" class="tab-pane fade show active" id="speed-advert">
                        <form>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio pmd-radio custom-control-inline">
                                            <input type="radio" id="vacancy" name="type" class="custom-control-input" checked>
                                            <label class="custom-control-label pmd-radio-ripple-effect" for="vacancy">{{$t('vacancy')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio pmd-radio custom-control-inline">
                                            <input type="radio" id="find-job" name="type" class="custom-control-input">
                                            <label class="custom-control-label pmd-radio-ripple-effect" for="find-job">{{$t('find-job')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio pmd-radio custom-control-inline">
                                            <input type="radio" id="rent" name="type" class="custom-control-input">
                                            <label class="custom-control-label" for="rent">{{$t('rent')}}</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="country">{{$t('country')}}</label>
                                                <select name="country" class="custom-select" id="country">
                                                    <option v-for="option in getCountries" v-bind:value="option.id">
                                                        {{ option.name[locale] }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="category">{{$t('rubric')}}</label>
                                                <select name="category" class="custom-select" id="category">
                                                    <option v-for="option in getCategories" v-bind:value="option.id">
                                                        {{ option.name[locale] }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">{{$t('description')}}</label>
                                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col">
                                    <h3>{{$t('contact-information')}}</h3>
                                    <div class="form-group">
                                        <label for="name">{{$t('name')}}</label>
                                        <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">{{$t('phone')}}</label>
                                        <input type="text" class="form-control" id="phone">
                                    </div>
                                    <div class="form-group">
                                        <label for="site">{{$t('site')}}</label>
                                        <input type="text" class="form-control" id="site">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success">{{$t('create')}}</button>
                        </form>
                    </div>
                    <div role="tablist" aria-labelledby="home-tab" class="tab-pane fade" id="extended-advert">Fixed tabs have equal width, calculated either as the view width divided by the number of tabs, or based on the widest tab label. To navigate between fixed tabs, touch the tab or swipe the content area left or right.</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                countries: "",
                category: "",
                locale: this.$i18n.locale
            }
        },

        beforeMount() {
            this.$store.dispatch('GET_COUNTRIES');
            this.$store.dispatch('GET_CATEGORIES');
        },

        computed: {
           getCountries() {
              return  this.$store.getters.countries
           },
            getCategories() {
                return  this.$store.getters.categories
            }
        },

       methods: {
       }
    }
</script>

<style scoped>

</style>
