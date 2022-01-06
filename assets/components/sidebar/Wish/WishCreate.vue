<template>
<div class="c-wish-add" >
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
                id="important" 
                name="important"
                v-model="addArray.important"
            >
            <label class="form-check-label" for="important">
                Jest ważne
            </label>
        </div>
        <div class="form-group mt-2">
            <label class="small" for="lists">Listy</label>
            <v-select 
                multiple 
                @search="fetchOptions"
                :options="wishlists"
                label="name"
                v-model="addArray.wishlists"
                append-to-body
                :calculate-position="withPopper"
                placeholder="Wpisz nazwę listy"
            >
                <div slot="no-options">Nie znaleziono listy o podanej nazwie</div>
            </v-select>
        </div>
        <button type="submit" class="btn btn-primary mt-2 btn-block">Zapisz</button>
    </form>
</div>
</template>

<script>
    // @todo: Validation, indicators
    import store from '../../../store/store';
    import wishCaller from '../../../store/wish/caller';
    import wishlistCaller from '../../../store/wishlist/caller';
    import vSelect from 'vue-select';
    import { createPopper } from '@popperjs/core'
    import Wishlist from '../../../store/wishlist/entity';
    import Wish from '../../../store/wish/entity';

    export default {
        components: {
            vSelect
        },

        props:{
            wishlist: Wishlist
        },

        data(){
            return {
                store: store.state,
                addArray: {
                    name: null,
                    important: false,
                    wishlists: this.wishlist ? [this.wishlist] : []
                },
                wishlists: []
            }
        },

        computed:{
            ownedWishlists: function(){
                return this
                .store
                .wishlists.
                filter(
                    (wishlist) => wishlist.isOwner(this.store.user)
                );
            }
        },

        methods:{
            submit(e){
                wishCaller
                .create(this.addArray)
                .then(
                    (response) => {
                        let wish = new Wish(response.data.wish);
                        store.add('wishes', wish); 
                        
                        for(const wishlistId of wish.wishlists){
                            let wishlist = store.get('wishlists', wishlistId);
                            if(wishlist.init){
                                wishlist.wishes.push(wish.id);
                                store.update('wishlists', wishlist.id, wishlist);
                            }
                        }
                        
                        let matched = this.$route.matched;
                        this.$router.push({ name: matched[matched.length - 2].name });
                    }
                )
                e.preventDefault();
            },

            withPopper(dropdownList, component, { width }) {
                dropdownList.style.width = "285px"
                dropdownList.style.left = "1381px"

                const popper = createPopper(component.$refs.toggle, dropdownList, {
                    placement: "bottom",
                    modifiers: [
                    {
                        name: 'offset',
                        options: {
                        offset: [0, -1],
                        },
                    },
                    {
                        name: 'toggleClass',
                        enabled: true,
                        phase: 'write',
                        fn({ state }) {
                            component.$el.classList.toggle(
                                'drop-up',
                                state.placement === 'top'
                            )
                        },
                    },
                    ],
                })

                return () => popper.destroy()
            },

            fetchOptions(search, loading){
                loading(true);
                wishlistCaller
                .search(
                    {
                        name: search,
                        role: 1
                    }
                )
                .then(
                    wishlists => {
                        this.wishlists = wishlists;
                        loading(false);
                    }
                );
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
    
    ::v-deep .vs__dropdown-toggle {
        overflow: auto;
        padding-right: 35px;
        align-items: center;
    }
    
    ::v-deep .vs__dropdown-toggle .vs__selected-options{
        max-height: 45px;
    }
    
    ::v-deep .v-select.drop-up.vs--open .vs__dropdown-toggle {
        border-radius: 0 0 4px 4px;
        border-top-color: transparent;
        border-bottom-color: rgba(60, 60, 60, 0.26);
    }

    ::v-deep .vs__dropdown-toggle .vs__actions{
        position: absolute;
        right: 15px;
    }
</style>