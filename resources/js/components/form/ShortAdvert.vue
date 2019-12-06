<template>
    <div class="form-group">
        <div class="custom-control custom-radio pmd-radio custom-control-inline">
            <input type="radio" id="vacancy" name="type" class="custom-control-input">
            <label class="custom-control-label pmd-radio-ripple-effect" for="vacancy">{{$t('vacancy')}}</label>
        </div>
        <div class="custom-control custom-radio pmd-radio custom-control-inline">
            <input type="radio" id="find-job" name="type" class="custom-control-input">
            <label class="custom-control-label pmd-radio-ripple-effect" for="find-job">{{$t('find-job')}}</label>
        </div>
        <div class="custom-control custom-radio pmd-radio custom-control-inline">
            <input type="radio" id="rent" name="type" class="custom-control-input">
            <label class="custom-control-label" for="rent">{{$t('rent')}}</label>
        </div>
    </div>
    <div class="form-group">
        <label for="advert-text">Advert text</label>
        <textarea class="form-control" id="advert-text" name="text" rows="3"></textarea>
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>

</style>
