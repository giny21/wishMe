<template>
<div class="c-wishlist-add">
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
                v-model="addArray.name"
            >
        </div>
        <div class="form-check mt-2">
            <input 
                class="form-check-input" 
                type="checkbox" 
                id="publicAvailable" 
                name="publicAvailable"
                v-model="addArray.publicAvailable"
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
    // @todo: Validation, indicators
    import store from '../../../store/store';
    import caller from '../../../store/wishlist/caller';
    import Wishlist from '../../../store/wishlist/entity';

    export default {
        components: {
        },

        data(){
            return {
                store: store.state,
                addArray: {}
            }
        },

        methods:{
            submit(e){
                caller
                .create(this.addArray)
                .then(
                    (response) => {
                        let wishlist = new Wishlist(response.data.wishlist);
                        store.add('wishlists', wishlist); 
                        let matched = this.$route.matched;
                        this.$router.push({ name: matched[matched.length - 2].name });
                    }
                )
                e.preventDefault();
            },
        },

        mounted(){
            this.addArray = {
                name: null,
                publicAvailable: false
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