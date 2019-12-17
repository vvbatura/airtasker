<template>
    <main>
        <div id="content-auth" class="content ">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
export default {
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



