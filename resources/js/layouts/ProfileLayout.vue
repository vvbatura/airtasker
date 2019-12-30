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
                        <p class="name_user text-center">John Smith</p>
                    </div>
                    <ul class="dash_list_route">
                        <li>
                            <router-link to="/dashboard">
                                Dasboard
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/payments-history">
                                Payments history
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/payment-method">
                                Payment methods
                            </router-link>
                        </li>
                        <li>
                            <router-link to="/notifications">
                                Notifications
                            </router-link>
                        </li>
                        <li>
                            <a href="/" class="dropdown">Settings</a>
                        </li>
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
    padding-top: 30px;
    margin-bottom: 25px;
    .img_size {
        width: 130px;
        height: 130px;
        margin: 0 auto 10px auto;
        border-radius: 50%;
        overflow: hidden;
        img {
            object-fit: cover;
            height: 100;
            width: 100;
        }
    }
}
.sidebar_box {
    position: fixed;
    width: 210px;
}
.profile_content {
    padding-left: 210px;
    width: 100%;
}
.dash_list_route {
    padding-left: 15px;
    li {
        a {
            color: #545a77;
            height: 44px;
            display: block;
            transition: .3s linear;
            &:hover {
                text-decoration: none;
                color: #292b32;
                transition: .3s linear;
            }
        }
    }
}
.sidebar_box {
    height: calc(100vh - 58px);
}
</style>



