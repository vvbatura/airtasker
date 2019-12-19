<template>
    <div class="login-form">
        <form @submit.prevent="submit">
            <h2 class="text-center mb-4">Check SMS</h2>
            <div class="form-group">
                <div class="input-group">
                    <input
                        type="text"
                        v-model="sms"
                        class="form-control"
                        name="text"
                        :placeholder="$t('enter-your-sms')"
                        required/>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <router-link class="frg_btn cancel_btn" :to="{name: 'login'}">{{$t('cancel')}}</router-link>
                <button type="submit" class="btn btn-lg frg_btn">{{$t('send')}}</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "ConfirmPhone",
    data() {
        return {
            sms: ''
        }
    }
}
</script>


<style scoped>

</style>