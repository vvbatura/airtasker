<template>
    <div class="profile_header custom_header">
        <Header />
        <main class="wrapper_box wrapper_profile">
            <div class="container">
                <h1>Profile layout</h1>
                <router-view></router-view>
            </div>
        </main>
        <!-- <Footer /> -->
    </div>
</template>

<script>
import Header from "../components/parts/Header";
import Footer from "../components/parts/Footer";

export default {
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
.profile_header {
    header {
        position: fixed;
    }
}
.wrapper_profile {
    padding-top: 58px;
}
</style>



