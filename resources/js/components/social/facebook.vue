<template>
    <button
        type="button"
        class="btn btn_facebook btn_social"
        @click="signInByFacebook">
        <i class="ri-facebook-circle-fill"></i>
        Facebook
    </button>
</template>

<script>
    import {openWindow, authorise} from '../../common/module/helper'
    export default {
        name: 'LoginWithFacebook',
        mounted () {
            window.addEventListener('message', this.onMessage, false)
        },

        beforeDestroy () {
            window.removeEventListener('message', this.onMessage)
        },

        methods: {
            signInByFacebook() {
                const newWindow = openWindow('', 'login');
                newWindow.location.href =  '/api/auth/login/facebook';
            },

            /**
             * @param {MessageEvent} e
             */
            onMessage (e) {
                if (e.origin !== window.origin || !e.data.token) {
                    return
                }

                let bound = authorise.bind(this);
                bound(e.data.token);

                this.$router.push({ name: 'home-page' });
            }
        }
    }
</script>

<style lang="scss">
.btn_facebook {
    background: rgb(24, 119, 242);
    color: #ffffff;
    font-size: 16px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    &:hover {
        color: #ffffff;
    }
    i {
        line-height: 1;
        font-size: 24px;
        margin-right: 5px;
    }
}
</style>