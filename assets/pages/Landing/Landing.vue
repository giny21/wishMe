<template>
    <landing-layout>
        <router-view></router-view>
    </landing-layout>
</template>

<script>
    import LandingLayout from '../../layouts/Landing.vue'

    export default {
        components: {
            LandingLayout
        }
    }
</script>