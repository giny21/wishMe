const store = {
    debug: true,
  
    state: {
        user: user,
        wishlists: [],
        wishes: [],
        messages: []
    },
  
    set(field, newValue) {
        if (this.debug) 
            console.log('Set ' + field + ' triggered with', newValue);
  
        this.state[field] = newValue;
    }
}
  
export default store;