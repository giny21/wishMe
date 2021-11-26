<template>
    <dashboard-layout>
        <router-view></router-view>
    </dashboard-layout>
</template>

<script>
    import DashboardLayout from '../../layouts/Dashboard'
    export default {
        components: { 
            DashboardLayout
        },
    }
</script>