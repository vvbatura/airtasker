<template>
    <main>
        <v-header />
        <div id="content-wrap" class="content">
            <router-view></router-view>
        </div>
        <v-footer />
    </main>

</template>

<script>
    import VHeader from "../components/blocks/Header";
    import VFooter from "../components/blocks/Footer";

    export default {
        data: () => ({

        }),
        props: {

        },
        components: {
            VHeader,
            VFooter
        },
    }
</script>

<style>
    #content-wrap {
        padding-bottom: 11.5rem;    /* Footer height */
    }

    #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 11.5rem;            /* Footer height */
    }
</style>



