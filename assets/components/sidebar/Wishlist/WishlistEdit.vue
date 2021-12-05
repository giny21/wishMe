<template>
<div class="c-wishlist-edit" v-if="wishlist" >
    <form 
        @submit="submit"
    >
        <div class="form-group mt-2">
            <label class="small" for="name">Nazwa</label>
            <input 
                id="name" 
                name="name" 
                class="form-control" 
                type="text" 
                maxlength="40" 
                required 
                v-model="editArray.name"
            >
        </div>
        <div class="form-check mt-2">
            <input 
                class="form-check-input" 
                type="checkbox" 
                id="publicAvailable" 
                name="publicAvailable"
                v-model="editArray.publicAvailable"
            >
            <label class="form-check-label" for="publicAvailable">
                Jest publiczna
            </label>
        </div>
        <button type="submit" class="btn btn-primary mt-2 btn-block">Zapisz</button>
    </form>
</div>
</template>

<script>
    import store from '../../../store/store';
    import caller from '../../../store/wishlist/caller';
    import Wishlist from '../../../store/wishlist/entity';

    export default {
        components: {
        },

        props:{
            wishlist: Wishlist
        },

        data(){
            return {
                store: store.state,
                editArray: {}
            }
        },

        methods:{
            submit(e){
                caller
                .edit(this.wishlist.id, this.editArray)
                .then(
                    () => {
                        this.wishlist.edit(this.editArray);
                        store.update('wishlists', this.wishlist.id, this.wishlist); 
                    }
                )
                e.preventDefault();
            }
        },

        watch: {
            wishlist: function(){
                if(this.wishlist)
                    this.editArray = {
                        name: this.wishlist.name,
                        publicAvailable: this.wishlist.publicAvailable
                    }
            }
        },

        mounted(){
            if(this.wishlist)
                this.editArray = {
                    name: this.wishlist.name,
                    publicAvailable: this.wishlist.publicAvailable
                }
        }
    }
</script>

<style scoped>
    h5, h6{
        font-size: 16px;
        text-align: center;

    }

    h6{
        font-size: 14px;
    }

    .btn-block{
        width: 100%;
    }
</style>