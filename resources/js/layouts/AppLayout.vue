<template>
    <div>
        <Header />
        <main class="wrapper_box">
            <router-view></router-view>
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
.wrapper_box {
    padding-bottom: 472px;
}
</style>



