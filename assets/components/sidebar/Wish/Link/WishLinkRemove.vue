<template>
    <span 
        class="c-wish-link-remove clickable"
        v-on:click="remove"
        v-if="canRemove()" 
    >
        <i class="fas fa-trash"></i>
    </span>
</template>

<script>
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import caller from '../../../../store/wish/caller';

export default {
    props: {
        wish: Wish,
        link: Object,
        owner: Object
    },

    data(){
        return {
            store: store.state
        }
    },

    methods: {
        remove(){
            caller
            .removeLink(this.wish.id, this.link.id)
            .then(
                response => {
                    let newValue = new Wish(response.data.wish);
                    store.update('wishes', this.wish.id, newValue); 
                }
            );
        },

        canRemove(){
            return this.owner ? this.owner.id == this.store.user.id : false;
        },
    }
}
</script>

<style scoped>
</style>