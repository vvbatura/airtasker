<template>
    <div class="view-content">
        <div class="container d-flex align-items-center">
            <div class="view_zone">
                <h1>The best person for the job isn't always who you think</h1>
                <h4>Find the people with the skills you need on Airtasker</h4>
                <a href="/" class="land_link modal_btn">
                    Get started now
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Home",
    }
</script>

<style lang="scss">
.view-content {
    background: url("/img/home-1.jpeg") no-repeat center top;
    background-size: cover; 
    min-height: 900px;
    color: #ffffff;
    font-family: "Montserrat", sans-serif;
    position: relative;
    &:after {
        content: '';
        display: block;
        position: absolute;
        width: 100vw;
        height: 100vh;
        background: rgba(0, 0, 0, 0.47);
        top: 0;
        left: 0;
        z-index: 0;
    }
    .container {
        height: 100vh;
        position: relative;
        z-index: 10;
    }
    h1 {
        font-size: 50px;
        font-weight: bold;
        margin-bottom: 15px;
    }
    h4 {
        font-size: 32px;
        margin-bottom: 40px;
    }
}
.view_zone {
    max-width: 880px;
}
.land_link {
    background: rgb(224, 68, 109);
    border-radius: 160px;
    padding: 16px 24px;
    color: #ffffff;
    font-size: 20px;
    &:hover {
        text-decoration: none;
        color: #ffffff;
    }
}
</style>

