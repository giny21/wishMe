<template>
    <div sticky-container class="l-actionbar col-12 d-flex">
        <div class="sticky-wrapper d-flex justify-content-center" v-sticky>
            <slot></slot>
        </div>
    </div>
</template>

<script>
import Sticky from 'vue-sticky-directive'

export default {
    directives: {
        Sticky
    }
}
</script>

<style scoped>
    .l-actionbar{
        position: absolute;
        height: 100%;
        right: 0px;
        top: 0px;
        z-index: 1000;
        width: 50px;
    }

    .sticky-wrapper{
        margin: 76px auto;
        width: 50px !important;
    }
</style>