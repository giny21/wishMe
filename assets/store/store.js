import wishlistCaller from "./wishlist/caller";
import wishCaller from "./wish/caller";

const store = {
    debug: true,
  
    state: {
        user: user,
        wishlists: [],
        wishes: []
        
    },

    callers: {
        wishlists: wishlistCaller,
        wishes: wishCaller
    },

    get(field, id) {
        if(!this.contains(field, id)){
            this.add(field, {'id': id, init: false});
            this.refresh(field, id);
        }

        return this.find(field, id);
    },

    refresh(field, id){
        this
        .callers[field]
        .fetch(id)
        .then(
            value => {
                this.update(field, id, value);
            }
        );
    },

    find(field, id){
        for(const value of this.state[field]){
            if(value.id == id)
                return value;
        }
    },

    contains(field, id){
        return Boolean(this.find(field, id));
    },
  
    set(field, values) {
        if (this.debug) 
            console.log('Set ' + field + ' triggered with', values);
  
        this.state[field] = values;
    },

    update(field, id, value){
        if(this.debug)
            console.log('Update single entity with id ' + id + ' of ' + field + ' triggered with ', value);

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

    updates(field, values){
        for(const value of values)
            this.update(field, value.id, value);
    },

    add(field, value){
        if(this.contains(field, value.id)){
            if(!this.find(field, value.id).init)
                this.update(field, value.id, value);
        }
        else{
            if(this.debug)
                console.log('Add single entity with id ' + value.id + ' to ' + field + ' triggered with ', value);
    
            let values = this.state[field];
            values.push(value);
            this.state[field] = values;
        }
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