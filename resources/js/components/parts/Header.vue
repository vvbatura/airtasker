
<template>
    <header id="header">
        <div class="container align-items-center justify-content-between d-flex">
            <div id="logo">
                <router-link class="logo" to="/">
                    <img src="img/white-logo.svg" alt="" />
                </router-link>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav_menu">
                    <li>
                        <router-link to="/">
                            Home
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/login">
                            Log in
                        </router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script>
    export default {
        name: "Header"
    }
</script>

<style lang="scss">
#header {
    height: 58px;
    //border-bottom: 1px solid #ccc;
    position: absolute;
    width: 100%;
    z-index: 100;
    .container {
        height: 100%;
    }
}
</style>
