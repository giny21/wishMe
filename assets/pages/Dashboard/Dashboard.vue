<template>
    <dashboard-layout>
        <router-view></router-view>
    </dashboard-layout>
</template>

<script>
    import DashboardLayout from '../../layouts/Dashboard.vue'
    export default {
        components: { 
            DashboardLayout
        },
    }
</script>