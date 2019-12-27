<template>
    <div class="auth_header">
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
.auth_header {
    header {
        background: #ffffff;
        transition: .3s linear;
        position: relative !important;
        border-bottom: 1px solid #ccc;
        box-shadow: 0 1px 0 0 rgba(0,0,0,.1);
        #AirtaskerLogo {
            path {
                fill: #008fb4;
            }
        }
        .head_menu {
            li + li {
                a {
                    color: #545a77;
                }
            }
        }
        .nav_menu {
            li {
                a {
                    color: #545a77;
                }
            }
            .become_tacker {
                border: 1px solid #545a77; 
            }
        }
        .arrow_select {
            i {
                color: #545a77;
            }
            .header_lang {
                color: #545a77;
            }
        }
        .hide_menu {
            .nav_menu {
                .become_tacker {
                    border: none;
                }
            }
        }
    }
}
</style>



