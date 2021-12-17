import Entity from "../entity";

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

    isOwner(user){
        if(!user) return false;

        let owner = this.getOwner();
        if(owner)
            return this.getOwner().id == user.id;
        else
            return true;
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

    getOwner(){
        let subscriptions = this
            .getWishlistsSubscriptions()
            .filter(
                (subscription) => subscription.role == ROLE_OWNER
            );
            
        if(subscriptions.length > 0) 
            return subscriptions[0].user;
    }

    getWishlistsSubscriptions(){
        return this
            .wishlists
            .map(
                (wishlist) => wishlist.subscriptions
            )
            .flat();
    }

    switchFulfilled(){
        this.fulfilled = !this.fulfilled;
    }
}

export default Wish;