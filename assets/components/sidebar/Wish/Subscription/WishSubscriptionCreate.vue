<template>
<div class="c-wish-add" >
    <button 
        type="button" 
        v-on:click="create" 
        v-if="canCreate()" 
        class="btn btn-primary mt-2 btn-block"
    >
        Dołącz
    </button>
</div>
</template>

<script>
    import store from '../../../../store/store';
    import Wish from '../../../../store/wish/entity';
    import caller from '../../../../store/wish/caller';

    export default {
        components: {
        },

        props: {
            wish: Wish
        },

        data(){
            return {
                store: store.state
            }
        },

        methods: {
            create(e){
                caller
                .addSubscription(this.wish.id)
                .then(
                    response => {
                        let newValue = new Wish(response.data.wish);
                        store.update('wishes', this.wish.id, newValue); 
                    }
                );
                e.preventDefault();
            },

            canCreate(){
                return !this.wish.fulfilled && !this.wish.isSubscriber(this.store.user);
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