<template>
    <button type="button" class="btn btn-primary btn-block" @click="signInByFacebook">facebook</button>
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
