<template>
    <form 
        class="form-inline c-wish-field-add mt-2"
        @submit="create"
        v-if="canCreate()"
    >
        <div class="input-group">
            <input 
                class="form-control" 
                id="name" 
                name="name" 
                type="text" 
                placeholder="np. Rozmiar, Kolor"
                required
                v-model="addArray.name"
            >
            <input 
                class="form-control" 
                id="name" 
                name="name" 
                type="text" 
                placeholder="np. XL, Czerwony"
                v-model="addArray.value"
            >
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">+</button>
            </div>
        </div>
    </form>
</template>

<script>
    // @todo: Validation, indicators
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import caller from '../../../../store/wish/caller';

export default {
    props: {
        wish: Wish,
        owner: Object
    },

    data(){
        return {
            store: store.state,
            addArray: {
                name: "",
                value: ""
            }
        }
    },

    methods: {
        create(e){
            caller
            .addField(this.wish.id, this.addArray)
            .then(
                response => {
                    let newValue = new Wish(response.data.wish);
                    store.update('wishes', this.wish.id, newValue); 
                }
            );
            e.preventDefault();
        },

        canCreate(){
            return this.owner ? this.owner.id == this.store.user.id : false;
        }
    }
}
</script>

<style scoped>
    .btn{
        border-radius: 0px 5px 5px 0px;
    }
</style>