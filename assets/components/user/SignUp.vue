<template>
    <form 
        class="row justify-content-md-center border-top shadow p-3 mb-1 bg-white" 
        @submit="submit"
        v-bind:class="{'was-validated': wasValidated}"
    >
        <div class="form-group mt-2">
            <label class="small" for="email">Email</label>
            <input 
                id="email" 
                v-model="email" 
                name="email" 
                class="form-control" 
                type="email" 
                minlength=1 
                required
            >
            <div class="invalid-feedback">Musisz podać email</div>
        </div>
        <div class="form-group mt-2">
            <label class="small" for="password">Hasło</label>
            <input
                id="password" 
                v-model="password" 
                name="password" 
                class="form-control" 
                type="password" 
                minlength=1 
                required
            >
            <div class="invalid-feedback">Musisz podać hasło</div>
        </div>
        <div class="form-group mt-2">
            <label class="small" for="passwordRepeat">Powtórz hasło</label>
            <input 
                id="passwordRepeat" 
                v-model="passwordRepeat" 
                name="passwordRepeat" 
                class="form-control" 
                type="password" 
                minlength=1 
                required
            >
            <div class="invalid-feedback">Musisz powtórzyć hasło</div>
        </div>
        <div class="invalid-feedback server" v-if="errorMessage" v-html="errorMessage"></div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-sm btn-primary" v-on:click="submit">Stwórz konto</button>
        </div>
    </form>
</template>

<script>
    import axios from "axios";

    export default {
        name: "sign-in",
        data: function() {
            return {
                email: null,
                password: null,
                passwordRepeat: null,
                errorMessage: null,
                wasValidated: null
            }
        },
        methods: {
            submit: function(e){
                this.wasValidated = true;
                if(this.email && this.password && this.passwordRepeat){
                    if(this.password === this.passwordRepeat){
                        this.wasValidated = false;
                        this
                        .call()
                        .then(
                            () => this.onResponse()
                        )
                        .catch(
                            error => this.onError(error.response)
                        );
                    }
                    else
                        this.errorMessage = "Podane hasła muszą być takie same";
                }
                e.preventDefault();
            },

            call: function(){
                return axios.post(
                    "/user/create", 
                    {
                        "email": this.email,
                        "password": this.password,
                        "passwordRepeat": this.passwordRepeat
                    }
                )
            },

            onResponse(){
                store
                window.location.reload();
            },

            onError(response){
                if(response.data.status == 500)
                    this.errorMessage = "Coś poszło nie tak, spróbuj później "
                        + " albo skontaktuj się z <a href='mailto:giny21@gmail.com'>wiewiórką</a>";
                else
                    this.errorMessage = response.data.detail;
            }
        }
    }
</script>

<style scoped>
    .invalid-feedback{
        font-size: 11px;
    }
    .invalid-feedback.server{
        display: block;
    }
</style>