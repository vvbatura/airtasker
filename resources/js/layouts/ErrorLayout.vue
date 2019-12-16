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
import Header from "../components/parts/Header";
import Footer from "../components/parts/Footer";

export default {
    components: {
        Header,
        Footer
    },
    data() {
        return {

        }
    },
    props: {

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



