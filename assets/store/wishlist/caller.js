import axios from "axios";
import Wishlist from "./entity";

const calls = {
    async fetchAll(){
        if(user){
            return axios
                .get("/list")
                .then(
                    response => 
                    response
                    .data
                    .wishlists
                    .map(
                        (wishlistJson) => new Wishlist(wishlistJson)
                    )
                )
                .catch(
                    error => {
                        console.log(error);
                        return [];
                    }
                );
        }
        else return new Promise(() => []);
    },

    async fetch(id){
        return axios
            .get("/list/"+id)
            .then(
                response => new Wishlist(response.data.wishlist)
            )
            .catch(
                error => {
                    console.log(error);
                    return null;
                }
            );
    },

    async switchFavorite(id){
        return axios
            .get("/list/"+id+"/favorite"); 
    },

    async edit(id, editArray){
        return axios
            .post(
                "/list/"+id+"/edit",
                JSON.stringify(editArray)
        );
    },

    async remove(id){
        return axios
            .get("/list/"+id+"/remove");
    },

    async create(addArray){
        return axios
            .post(
                "/list/create",
                JSON.stringify(addArray)
        );
    },

    async addSubscription(id, addSubscriptionArray){
        return axios
            .post(
                "/list/"+id+"/subscription/create",
                JSON.stringify(addSubscriptionArray)
        );
    },

    async removeSubscription(id, subscriptionId){
        return axios
            .get("/list/"+id+"/subscription/"+subscriptionId+"/remove");
    }
}

export default calls;