import Entity from "../entity";
import store from "../store";

const ROLE_OWNER = 1;
const ROLE_SUBSCRIBER = 2;

class Wish extends Entity{
    constructor(json){
        super();
        this.id = json.id;
        this.name = json.name;
        this.important = json.important;
        this.fulfilled = json.fulfilled;
        this.fields = json.fields;
        this.links = json.links;
        this.subscriptions = json.subscriptions;
        this.wishlists = json.wishlists;
    }

    isSubscriber(user){
        if(!user) return false;

        return Boolean(this.getSubscription(user));
    }

    getSubscription(user){
        let subscriptions = this
            .subscriptions
            .filter(
                (subscription) => subscription.user.id == user.id
            );
            
        if(subscriptions.length > 0) 
            return subscriptions[0];
    }

    switchFulfilled(){
        this.fulfilled = !this.fulfilled;
    }
}

export default Wish;