<template>
    <div class="c-wish-field">
        <div>
            <span>
                {{field.name}}
            </span>
            <span>
                {{field.value}}
            </span>
        </div>
        <div>
            <wish-field-remove 
                :wish="wish" 
                :field="field"
                :owner="owner"
            >
            </wish-field-remove>
            <wish-field-switch-important
                :wish="wish" 
                :field="field"
                :owner="owner"
            >
            </wish-field-switch-important>
        </div>
    </div>
</template>

<script>
import store from '../../../../store/store';
import Wish from '../../../../store/wish/entity';
import WishFieldRemove from './WishFieldRemove.vue';
import WishFieldSwitchImportant from './WishFieldSwitchImportant.vue';

export default {
    components: {
        WishFieldRemove,
        WishFieldSwitchImportant 
    },

    props: {
        wish: Wish,
        field: Object,
        owner: Object
    },

    data(){
        return {
            store: store.state
        }
    }
}
</script>

<style scoped>
    .c-wish-field{
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-content: center;
        padding: 2px 5px;
    }
    .c-wish-field:nth-child(even) {
        background-color: #e3f2fd;
    }
</style>