<template>
<div class="c-wishlist">
    <div class="actions">
        <div>
            <span v-if="wishlist.publicAvailable" key="public">
                <i class="fas fa-lock-open" title="Publiczna"></i>
            </span>
            <span v-else key="notPublic">
                <i class="fas fa-lock" title="Prywatna"></i>
            </span>
        </div>
        <div>
            <router-link :to="'/list/' + wishlist.id + '/edit'" v-on:click="sidebarShow = true">
                <i class="fas fa-pen" v-if="wishlist.isOwner(store.user)"></i>
            </router-link>
        </div>
    </div>
    <header>
        <div class="h6">
            {{wishlist.name}}
            <a class="clickable" v-on:click="switchFavorite" v-if="store.user">
                <span v-if="wishlist.getSubscription(store.user).favorite" key="fav">
                    <i class="fas fa-heart"></i>
                </span>
                <span v-else key="notFav">
                    <i class="far fa-heart"></i>
                </span>
            </a>
        </div>
        <div class="d-inline-flex justify-content-center m-1">
            <div v-if="!wishlist.isOwner(store.user)">
                <label 
                    class="badge bg-warning" 
                    v-bind:title="wishlist.getOwner().email"
                >
                    <i class="fas fa-user"></i>
                    {{wishlist.getOwner().email.split('@', 1)[0]}}
                </label>
            </div>
        </div>
    </header>
    <content>
        <div class="element">
            <span class="counter">
                {{wishlist.wishes.length > 9 ? "9+" : wishlist.wishes.length}}
            </span>
            <i class="fas fa-gift"></i>
            <p class="element-title">Życzenia</p>
        </div>

        <router-link 
            :to="'/list/' + wishlist.id + '/subscription'"
            class="element" 
        >
            <span class="counter">
                {{wishlist.subscriptions.length > 9 ? "9+" : wishlist.subscriptions.length}}
            </span>
            <i class="fas fa-user-friends"></i>
            <p class="element-title">Znajomi</p>
        </router-link>
    </content>
</div>
</template>

<script>
import store from '../../../store/store';
import caller from '../../../store/wishlist/caller';
import Wishlist from '../../../store/wishlist/entity';

export default {
    props: {
        wishlist: Wishlist
    },
    data(){
        return {
            store: store.state,
            sidebarShow: false
        }
    },
    methods:{
        switchFavorite(){
            this.wishlist.switchFavorite(this.store.user);
            store.update('wishlists', this.wishlist.id, this.wishlist);
            caller.switchFavorite(this.wishlist.id);
        }
    }
}
</script>

<style scoped>
    .c-wishlist{
        height: 200px;
        width: 290px;
        display: flex;
        align-items: center;
        padding: 10px 0 5px 0;
        margin: 18px;
        border: dotted black 1px;
        border-radius: 0.25rem;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
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
        max-width: 90px;
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