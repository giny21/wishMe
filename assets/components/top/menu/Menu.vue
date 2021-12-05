<template>
    <b-nav class="navbar navbar-expand-lg navbar-light c-menu">
        <b-nav-item href="#/list">Listy</b-nav-item>
        <b-nav-item href="#/wish">Życzenia</b-nav-item>
        <b-nav-item href="user/sign-out">Wyloguj</b-nav-item>
    </b-nav>
</template>

<script>
import { BNav, BNavItem, BNavItemDropdown, BDropdownItem } from "bootstrap-vue";
import store from "../../../store/store";

export default {
    components: {
        BNav, 
        BNavItem, BNavItemDropdown, BDropdownItem
    },
    data(){
        return {
            isDisabled: !(Boolean)(store.state.user)
        }
    }
}
</script>

<style scoped>
    .c-menu {
        background-color: #e3f2fd;
    }

    ::v-deep .dropdown-menu{
        background-color: #e3f2fd; 
        border: 0px; 
        margin-top: 0.5rem; 
        border-top: 1px dotted black; 
        border-radius: 0px;
        z-index: 99999999;
    }

    ::v-deep .is-disabled > *{
        color: darkgrey;
    }
</style>