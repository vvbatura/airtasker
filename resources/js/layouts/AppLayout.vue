<template>
    <main>
        <div class="container">
            <router-view></router-view>
        </div>
    </main>

</template>

<script>

    export default {
        props: {},
        components: {

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
    @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600');

    body,
    html {
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Source Sans Pro', sans-serif;
        font-size: 16px;
        background-color: #f2f4f7;
        color: #262626;
    }

    .logout {
        color: #000000;
    }

    .v-sidebar-menu {
        padding-top: 4%;
        z-index: 1;
        flex-direction: column-reverse;

        &.vsm_collapsed {
            .vsm--title,
            .vsm--mobile-bg,
            .v-sidebar-menu .vsm--link, .vsm--dropdown, .vsm--item.vsm--item_open {
                display: none;
            }
        }
    }
</style>



