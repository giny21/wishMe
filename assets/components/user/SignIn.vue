<template>
    <form 
        class="row justify-content-md-center border-top shadow p-3 mb-1 bg-white c-sign-in" 
        @submit="submit"
        v-bind:class="{'was-validated': wasValidated}"
    >
        <div class="form-group mt-2">
            <label class="small" for="email">Email</label>
            <input 
                name="email" 
                v-model="email" 
                id="email" 
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
                name="password" 
                v-model="password" 
                id="password" 
                class="form-control" 
                type="password" 
                minlength=1 
                required
            >
            <div class="invalid-feedback">Musisz podać hasło</div>
        </div>
        <div class="invalid-feedback server" v-if="errorMessage" v-html="errorMessage"></div>
        <div class="form-group mt-2">
            <button type="submit" class="btn btn-sm btn-primary" v-on:click="submit">Zaloguj</button>
        </div>
        <router-link to="/sign-up">Chcę stworzyć nowe konto</router-link>
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
                errorMessage: null,
                wasValidated: null
            }
        },
        methods: {
            submit: function(e){
                this.wasValidated = true;
                if(this.email && this.password){
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
                e.preventDefault();
            },

            call: function(){
                return axios.post(
                    "/user/sign-in", 
                    {
                        "email": this.email,
                        "password": this.password
                    }
                )
            },

            onResponse(){
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