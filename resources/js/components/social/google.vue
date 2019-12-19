<template>
    <button type="button" class="btn btn_google btn_social" @click="signInByGoogle">
        <img src="/img/search.svg" alt="" />
        Google
    </button>
</template>

<script>
    import {openWindow, authorise} from '../../common/module/helper'
    export default {
        name: 'LoginWithGoogle',
        mounted () {
            window.addEventListener('message', this.onMessage, false)
        },

        beforeDestroy () {
            window.removeEventListener('message', this.onMessage)
        },

        methods: {
            signInByGoogle() {
                const newWindow = openWindow('', 'login');
                newWindow.location.href =  '/api/auth/login/google';
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
.btn_google {
    border: 1px solid rgb(231, 235, 251);
    color: rgb(41, 43, 50);
    font-weight: bold;
    img {
        width: 24px;
        margin-right: 8px;
    }
}
</style>