
<template>
    <header id="header">
        <div class="container align-items-center justify-content-between d-flex">
            <div class="d-flex align-items-center">
                <div id="logo" class="logo_header">
                    <router-link class="logo" to="/">
                        <img src="img/white-logo.svg" alt="" />
                    </router-link>
                </div>
                <ul class="head_menu">
                    <li>
                       <a href="/" class="red_btn become_tacker">
                            Post a task
                        </a> 
                    </li>
                    <li>
                        <a href="/">
                            Categories
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            Browse tasks
                        </a>
                    </li>
                    <li>
                        <a href="/">
                            How it works
                        </a>
                    </li>
                </ul>
            </div>
            <nav id="nav-menu-container">
                <ul class="nav_menu">
                    <li>
                        <router-link to="/">
                            Sign up
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/login">
                            Log in
                        </router-link>
                    </li>
                    <li>
                        <a href="/" class="become_tacker">
                            Become a Tasker
                        </a>
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
.become_tacker {
    padding: 6px 16px;
    border: 1px solid #ffffff;
    border-radius: 34px;
    &:hover {
        text-decoration: none;
    }
}
.red_btn {
    background: #e0446d;
    padding: 6px 16px;
    border-radius: 34px;
    color: #ffffff;
    border: 1px solid #e0446d;
    &:hover {
        text-decoration: none;
        color: #ffffff;
    }
}
.logo_header {
    margin-right: 40px;
}
.head_menu {
    display: flex;
    li {
        margin-right: 20px;
        a {
            color: #ffffff;
        }
        &:last-of-type {
            margin-right: 0;
        }
    }
}
</style>
