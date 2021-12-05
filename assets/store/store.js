import wishlistCaller from "./wishlist/caller";

const store = {
    debug: true,
  
    state: {
        user: user,
        wishlists: [],
        wishlistsInitiated: false,
        wishes: [],
        messages: [],
        
    },

    callers: {
        wishlists: wishlistCaller
    },

    init() {
        this
        .callers
        .wishlists
        .fetchAll()
        .then(
            wishlists => {
                this.updates("wishlists", wishlists);
                this.updates("wishlistsInitiated", true);
            }
        );
    },

    get(field, id) {
        for(const value of this.state[field]){
            if(value.id == id)
                return value;
        }

        this
        .callers[field]
        .fetch(id)
        .then(
            value => {
                this.update(field, id, value);
            }
        );
    },
  
    updates(field, values) {
        if (this.debug) 
            console.log('Set ' + field + ' triggered with', values);
  
        this.state[field] = values;
    },

    update(field, id, value){
        if(this.debug)
            console.log('Set single entity with id ' + id + ' of ' + field + ' triggered with ', value);

        this.state[field] = this
            .state[field]
            .map(
                storedValue => {
                    if(storedValue.id === value.id)
                        return value;
                        
                    return storedValue;
                }
            );
    },

    add(field, value){
        if(this.debug)
            console.log('Add single entity with to ' + field + ' triggered with ', value);

        let values = this.state[field];
        values.push(value);
        this.state[field] = values;
    },

    remove(field, value){
        if(this.debug)
            console.log('Remove single entity with from ' + field + ' triggered with ', value);

        this.state[field] = this
            .state[field]
            .filter(
                storedValue => storedValue.id != value.id
            );
    }
}
  
export default store;