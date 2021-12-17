import Entity from "../entity";

const ROLE_OWNER = 1;
const ROLE_SUBSCRIBER = 2;

class Wishlist extends Entity{
    constructor(json){
        super();
        this.id = json.id;
        this.name = json.name;
        this.subscriptions = json.subscriptions;
        this.publicAvailable = json.publicAvailable;
        this.wishes = json.wishes;
    }

    isOwner(user){
        if(!user) return false;

        return this.getOwner().id == user.id;
    }

    isSubscriber(user){
        if(!user) return false;

        return Boolean(this.getSubscription(user));
    }

    getOwner(){
        return this
            .subscriptions
            .filter(
                (subscription) => subscription.role == ROLE_OWNER
            )[0]
            .user;
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

    switchFavorite(user){
        let subscription = this.getSubscription(user);
        subscription.favorite = !subscription.favorite;
    }
}

export default Wishlist;