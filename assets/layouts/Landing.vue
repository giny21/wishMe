<template>
    <div class="d-flex justify-content-center">
        <div class="d-flex justify-content-center flex-column p-3" style="max-width: 420px;">
            <img v-bind:src="'build/images/logo.png'">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {}
</script>