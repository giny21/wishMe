import { reactive } from 'vue'

const store = {
    debug: true,
  
    state: reactive({
        user: null,
        wishlists: [],
        wishes: [],
        messages: []
    }),
  
    set(field, newValue) {
        if (this.debug) 
            console.log('Set ' + field + ' triggered with', newValue);
  
        this.state[field] = newValue;
    }
}
  
export default store;