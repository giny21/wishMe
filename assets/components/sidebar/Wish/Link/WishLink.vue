<template>
    <div class="c-wish-link">
        <div>
            <span>
                <a v-bind:href="link.rawLink" target=”_blank”>{{link.rawLink}}</a>
            </span>
        </div>
        <div>
            <wish-link-remove 
                :wish="wish" 
                :link="link"
                :owner="owner"
            >
            </wish-link-remove>
        </div>
    </div>
</template>

<script>
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import WishLinkRemove from './WishLinkRemove.vue';

export default {
    components: {
        WishLinkRemove
    },

    props: {
        wish: Wish,
        link: Object,
        owner: Object
    },

    data(){
        return {
            store: store.state
        }
    }
}
</script>

<style scoped>
    .c-wish-link{
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-content: center;
        padding: 2px 5px;
    }
    .c-wish-link:nth-child(even) {
        background-color: #e3f2fd;
    }
</style>