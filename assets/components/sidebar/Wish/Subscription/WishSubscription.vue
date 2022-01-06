<template>
    <div class="c-wish-subscription" v-if="!isOwner()">
        <div>
            <span>
                {{subscription.user.email}}
            </span>
        </div>
        <div>
            <wish-subscription-remove
                :wish="wish" 
                :subscription="subscription"
            >
            </wish-subscription-remove>
        </div>
    </div>
</template>

<script>
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import WishSubscriptionRemove from './WishSubscriptionRemove.vue';

export default {
    components: {
        WishSubscriptionRemove
    },

    props: {
        wish: Wish,
        subscription: Object,
        owner: Object
    },

    data(){
        return {
            store: store.state
        }
    },

    methods: {
        isOwner: function(){
            return this.owner && this.owner.id === this.subscription.user.id;
        }
    }
}
</script>

<style scoped>
    .c-wish-subscription{
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-content: center;
        padding: 2px 5px;
    }
    .c-wish-subscription:nth-child(even) {
        background-color: #e3f2fd;
    }
</style>