<template>
    <button type="button" class="btn btn-primary btn-block" @click="signInByGoogle">google</button>
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
                const newWindow = openWindow('', 'login')
                newWindow.location.href =  '/api/auth/login/google'
            },

            /**
             * @param {MessageEvent} e
             */
            onMessage (e) {
                if (e.origin !== window.origin || !e.data.token) {
                    return
                }

                let bound = authorise.bind(this)
                bound(e.data.token);

                this.$router.push({ name: 'home-page' })
            }
        }
    }




</script>
