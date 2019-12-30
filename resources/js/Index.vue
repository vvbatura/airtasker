<template>
    <div id="wrapper">
        <template v-if="$auth.ready()">
            <component :is="layout"></component>
        </template>
        <template v-if="!$auth.ready()">
            loading ...
        </template>
    </div>
</template>

<script>
import AppLayout from './layouts/AppLayout'
import AuthLayout from './layouts/AuthLayout'
import ErrorLayout from "./layouts/ErrorLayout";
import ProfileLayout from "./layouts/ProfileLayout";

export default {
    computed: {
        layout () {
            return this.$route.meta.layout;
        }
    },
    components: {
        AppLayout,
        AuthLayout,
        ErrorLayout,
        ProfileLayout
    }
}
</script>
