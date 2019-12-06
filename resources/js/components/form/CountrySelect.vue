<template>
    <select name="country" class="custom-select" id="country" v-model="selected" @change="emitChange">
        <option v-for="option in getCountries" :value="option.id">
            {{ option.name[locale] }}
        </option>
    </select>
</template>

<script>
    export default {
        props: {
            selectedItem: {
                type: Number,
                default: ''
            }
            },
        data() {
            return {
                locale: this.$i18n.locale,
                selected: this.selectedItem,
            }
        },

        beforeMount() {
            this.$store.dispatch('GET_COUNTRIES');
        },

        computed: {
            getCountries() {
                return  this.$store.getters.countries
            }
        },

        methods: {
            emitChange(e) {
                this.$emit('change', this.selected);
            },
        }

    }
</script>

<style scoped>

</style>
