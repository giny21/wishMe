<template>
    <div sticky-container class="l-sidebar shadow border-left bg-light col-12 d-flex">
        <div class="sticky-wrapper d-flex justify-content-center" v-sticky>
            <div class="sidebar-btn d-flex shadow border-left" v-on:click="close">
                <i class="fas fa-times"></i>
            </div>
            <section>
                <slot></slot>
            </section>
        </div>
    </div>
</template>

<script>
import Sticky from 'vue-sticky-directive'

export default {
    directives: {
        Sticky
    },
    methods: {
        close(){
            let matched = this.$route.matched;
            this.$router.push({ name: matched[matched.length - 2].name });
        }
    }
}
</script>

<style scoped>
    .l-sidebar{
        position: absolute;
        height: 100%;
        right: 0px;
        top: 0px;
        z-index: 1000;
        width: 330px;
    }

    .sticky-wrapper{
        margin: 16px auto;
        width: 330px !important;
    }

    .sidebar-btn{
        position: absolute;
        border-radius: 100px 0px 0px 100px;
        font-size: 20px;
        color: white;
        width: 30px;
        height: 50px;
        left: -30px;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        background-color: black;
    }

    section{
        margin-bottom: 8px;
        width: 300px;
    }

    ::v-deep section content{
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        max-height: calc(100vh - 260px);
    }

    ::v-deep section content>div, ::v-deep section content>h6{
        border: 1px dotted gray;
        border-right: 5px dotted #0d6efd;
        border-radius: 5px 0px 0px 5px;
        background-color: white;
        width: 100%;
        max-height: calc(100vh - 260px);
        margin-top: 10px;
    }

    ::v-deep section content>div{
        overflow: auto;
        padding: 3px;
        padding-right: 6px;
    }

    ::v-deep section content>h6{
        padding: 10px 5px;
        padding-right: 8px;
        text-align: center;
    }
</style>