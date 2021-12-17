<template>
    <span 
        class="c-wish-field-remove clickable"
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
        field: Object
    },

    data(){
        return {
            store: store.state
        }
    },

    methods: {
        remove(){
            caller
            .removeField(this.wish.id, this.field.id)
            .then(
                response => {
                    let newValue = new Wish(response.data.wish);
                    store.update('wishes', this.wish.id, newValue); 
                }
            );
        },

        canRemove(){
            return this.wish.isOwner(this.store.user);
        },
    }
}
</script>

<style scoped>
</style>