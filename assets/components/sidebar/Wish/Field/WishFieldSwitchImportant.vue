<template>
    <span 
        class="c-wish-field-switch-important clickable"
        v-on:click="switchImportant"
        v-if="canSwitchImportant()" 
    >
        <span v-if="field.important" key="important">
            <i class="fas fa-star"></i>
        </span>
        <span v-else key="notImportant">
            <i class="far fa-star"></i>
        </span>
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
        switchImportant(){
            caller
            .switchImportantField(this.wish.id, this.field.id)
            .then(
                response => {
                    let newValue = new Wish(response.data.wish);
                    store.update('wishes', this.wish.id, newValue); 
                }
            );
        },

        canSwitchImportant(){
            return this.wish.isOwner(this.store.user);
        },
    }
}
</script>

<style scoped>
</style>