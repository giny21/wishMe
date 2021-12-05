class Entity extends Object{
    constructor(){
        super();
    }

    edit(editArray){
        for(const [key, value] of Object.entries(editArray)){
            if(this.hasOwnProperty(key))
                this[key] = value;
        }
    }
}

export default Entity;