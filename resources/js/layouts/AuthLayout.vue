<template>
    <div class="auth_header custom_header">
        <Header />
        <main>
            <div id="content-auth" class="content ">
                <router-view></router-view>
            </div>
        </main>
    </div>
</template>

<script>
import Header from "../components/parts/Header";

export default {
    components: {
        Header
    },
    data() {
        return {

        }
    }
}
</script>

<style lang="scss">
#content-auth {
    min-height: 100vh;
    display: flex;
    align-items: center;
}
</style>



