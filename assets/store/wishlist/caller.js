import axios from "axios";
import Wishlist from "./entity";

const calls = {
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

    async getsPageIds(page, sort, role){
        return axios
            .get("/list/page/" + page + "/" + sort + "/" + role);
    },

    async search(params){
        return axios
        .post(
            "/list/search",
            JSON.stringify(params)
        )
        .then(
            response => response
                .data
                .wishlists
                .map(
                    wishlist => new Wishlist(wishlist)
                )
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
            )
            .then(
                response => new Wishlist(response.data.wishlist)
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