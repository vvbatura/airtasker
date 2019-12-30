<template>
    <div class="profile_header custom_header">
        <Header />
        <main class="wrapper_box wrapper_profile">
            <div class="container">
                <div class="sidebar_box">
                    <div class="img_name">
                        <div class="img_size">
                            <img src="img/blog-1.jpg" alt=""/>
                        </div>
                        <p class="name_user">John Smith</p>
                    </div>
                    <ul class="dash_list_route">
                        <router-link to="/dashboard">
                            Dasboard
                        </router-link>
                        <router-link to="/payments-history">
                            Payments history
                        </router-link>
                        <router-link to="/payment-method">
                            Payment methods
                        </router-link>
                        <router-link to="/notifications">
                            Notifications
                        </router-link>
                        <a href="/" class="dropdown">Settings</a>
                    </ul>
                </div>
                <div class="profile_content">
                    <router-view></router-view>
                </div>
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
.img_name {
    .img_size {
        width: 130px;
        height: 130px;
        margin-bottom: 10px;
        border-radius: 50%;
        overflow: hidden;
        img {
            object-fit: cover;
            height: 100;
            width: 100;
        }
    }
}
</style>



