<template>
    <div>
        <Header />
        <main class="wrapper">
            <div class="container">
                <router-view></router-view>
            </div>
        </main>
        <Footer />
    </div>
</template>

<script>
import Header from "../components/parts/Header";
import Footer from "../components/parts/Footer";

export default {
    props: {},
    components: {
        Header,
        Footer
    },
    methods: {
        onToggleCollapse(collapsed) {
            this.collapsed = collapsed
        },
        onItemClick(event, item) {
        }
    }
}
</script>

<style lang="scss">

</style>



