<template>
<div class="c-wish">
    <div class="wish-wrapper" v-if="wish && wish.init" :class="{'is-fulfilled': wish.fulfilled}">
        <div class="actions">
            <div>
                <span v-if="wish.important" key="important">
                    <i class="fas fa-star" title="Ważne"></i>
                </span>
            </div>
            <div>
                <router-link :to="sidebarUrl('edit')" v-if="isOwner">
                    <i class="fas fa-pen"></i>
                </router-link>
            </div>
        </div>
        <header>
            <div class="h6">
                {{wish.name}}
                <span class="clickable" v-on:click="switchFulfilled" v-if="!isOwner">
                    <span v-if="wish.fulfilled" key="fulfilled">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <span v-else key="notFulfilled">
                        <i class="far fa-check-circle"></i>
                    </span>
                </span>
            </div>
            <div class="d-inline-flex justify-content-center m-1">
                <div v-if="isOwner">
                    <label 
                        class="badge bg-primary" 
                        v-for="wishlist in wishlists"
                        :key="wishlist.id"
                    >
                        <i class="fas fa-clipboard-list"></i>
                        {{wishlist.init ? wishlist.name : ""}}
                    </label>
                </div>
                <div v-else>
                    <label 
                        class="badge bg-warning" 
                        v-bind:title="owner ? owner.email : ''"
                    >
                        <i class="fas fa-user"></i>
                        {{owner ? owner.email.split('@', 1)[0] : ""}}
                    </label>
                </div>
            </div>
        </header>
        <content>
            <router-link 
                :to="sidebarUrl('field')" 
                class="element"
            >
                <span class="counter">{{wish.fields.length > 9 ? "9+" : wish.fields.length}}</span>
                <i class="fas fa-puzzle-piece"></i>
                <p class="wish-box-body-element-title">Cechy</p>
            </router-link>

            <router-link 
                :to="sidebarUrl('link')" 
                class="element"
            >
                <span class="counter">{{wish.links.length > 9 ? "9+" : wish.links.length}}</span>
                <i class="fas fa-link"></i>
                <p class="wish-box-body-element-title">Linki</p>
            </router-link>
            
            <div class="element" v-if="wish.fulfilled">
                <i class="fas fa-check-circle"></i>
                <p class="wish-box-body-element-title">Wypełnione</p>
            </div>

            <div class="element" v-if="isOwner && !wish.fulfilled">
                <span class="counter">{{wish.subscriptions.length - 1 > 9 ? "9+" : wish.subscriptions.length - 1}}</span>
                <i class="fas fa-user-friends"></i>
                <p class="wish-box-body-element-title">Znajomi</p>
            </div>

            <router-link 
                :to="sidebarUrl('subscription')" 
                class="element" 
                v-if="!isOwner && !wish.fulfilled"
            >
                <span class="counter">{{wish.subscriptions.length - 1 > 9 ? "9+" : wish.subscriptions.length - 1}}</span>
                <i class="fas fa-user-friends"></i>
                <p class="wish-box-body-element-title">Znajomi</p>
            </router-link>
        </content>
    </div>
    <div class="col-12 d-flex justify-content-center align-items-center mt-4" v-else>
        <b-spinner variant="primary" label="Spinning"></b-spinner>
    </div>
</div>
</template>

<script>
import store from '../../../store/store';
import caller from '../../../store/wish/caller'; 
import Wish from '../../../store/wish/entity';

export default {
    props: {
        wish: Wish|Object
    },

    data(){
        return {
            store: store.state
        }
    },

    computed: {
        wishlists: function(){
            return this
                .wish
                .wishlists
                .map(
                    wishlistId => store.get('wishlists', wishlistId)
                );
        },
        owner: function(){
            if(this.wish.wishlists.length === 0)
                return this.store.user;

            let wishlists = this
                .wishlists
                .filter(
                    wishlist => wishlist.init
                );

            if(wishlists.length > 0)
                return wishlists[0].getOwner();
        },
        isOwner: function(){
            if(this.owner)
                return this.owner.id == this.store.user.id;

            return false;
        },
    },

    methods:{
        sidebarUrl: function(subpage){
            let routeTable = this.$route.name.split(/(?=[A-Z])/);
            if(routeTable[0] === 'Wishlist')
                return '/list/' + this.$route.params.wishlist + '/wish/' + this.wish.id + '/' + subpage;
            
            return '/wish/' + this.wish.id + '/' + subpage;
        },
        switchFulfilled(){
            this.wish.switchFulfilled();
            store.update('wishes', this.wish.id, this.wish);
            caller.switchFulfilled(this.wish.id);
        }
    }
}
</script>

<style scoped>
    .c-wish{
        height: 200px;
        width: 290px;
        margin: 18px;
        border: dotted black 1px;
        border-radius: 0.25rem;
    }

    .wish-wrapper{
        display: flex;
        align-items: center;
        padding: 10px 0 5px 0;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        height: 100%;
    }

    .is-fulfilled{
        background-color: #baed9e;
    }

    .actions{
        display: flex;
        justify-content: space-between;
        width: 100%;
        position: absolute;
        top: 0px;
        font-size: 12px;
        padding: 4px 5px;
    }

    header{
        display: flex;
        flex-direction: column;
        text-align: center;
        z-index: 100;
    }

    header .h6{
        word-break: break-word;
        font-size: 15px;
        margin: 0px 20px;
    }

    header .badge{
        white-space: nowrap; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        margin: 2px;
    }

    content{
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        background-color: white;
    }

    content .element{
        position: relative;
        flex: 50%;
        text-align: center;
        font-size: 24px;
        border-top: dotted 1px gray;
        border-bottom: dotted 1px gray;
        text-decoration: none;
    }

    content .element:nth-child(odd){
        border-top: 0px;
        border-right: dotted 1px gray;
    }

    content .element:nth-child(-n+2){
        border-top: dotted 1px gray !important;
    }

    content .element:last-child{
        border-top: 0px;
        border-right: 0px;
    }

    content a.element:hover{
        color: gold;
    }

    content .element-title{
        font-size: 12px;
        margin: 0 0 3px 0;
    }
</style>