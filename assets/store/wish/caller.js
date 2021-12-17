import axios from "axios";
import Wish from "./entity";

const calls = {
    async fetch(id){
        return axios
            .get("/wish/"+id)
            .then(
                response => new Wish(response.data.wish)
            )
            .catch(
                error => {
                    console.log(error);
                    return null;
                }
            );
    },

    async getsPageIds(page, sort, type){
        return axios
            .get("/wish/page/" + page + "/" + sort + "/" + type);
    },

    async edit(id, editArray){
        return axios
            .post(
                "/wish/"+id+"/edit",
                JSON.stringify(editArray)
            )
            .then(
                response => new Wish(response.data.wish)
            );
    },

    async create(addArray){
        return axios
            .post(
                "/wish/create",
                JSON.stringify(addArray)
        );
    },

    async remove(id){
        return axios
            .get("/wish/"+id+"/remove");
    },

    async switchFulfilled(id){
        return axios
            .get("/wish/"+id+"/fulfilled"); 
    },

    async addField(id, addFieldArray){
        return axios
            .post(
                "/wish/"+id+"/field/create",
                JSON.stringify(addFieldArray)
        );
    },

    async removeField(id, fieldId){
        return axios
            .get("/wish/"+id+"/field/"+fieldId+"/remove");
    },

    async switchImportantField(id, fieldId){
        return axios
            .get("/wish/"+id+"/field/"+fieldId+"/important");
    },

    async addLink(id, addLinkArray){
        return axios
            .post(
                "/wish/"+id+"/link/create",
                JSON.stringify(addLinkArray)
        );
    },

    async removeLink(id, linkId){
        return axios
            .get("/wish/"+id+"/link/"+linkId+"/remove");
    },

    async addSubscription(id){
        return axios
            .get("/wish/"+id+"/subscription/create");
    },

    async removeSubscription(id, subscriptionId){
        return axios
            .get("/wish/"+id+"/subscription/"+subscriptionId+"/remove");
    }
}

export default calls;