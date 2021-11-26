import './styles/app.scss';

import '@fortawesome/fontawesome-free/js/fontawesome'
import '@fortawesome/fontawesome-free/js/solid'
import '@fortawesome/fontawesome-free/js/regular'
import '@fortawesome/fontawesome-free/js/brands'
import 'select2';

import * as Vue from 'vue';
import * as VueRouter from 'vue-router';
import store from './store';
import routes from './routes';
import axios from 'axios';

$(
    () => {
        $('.modal select')
        .select2();
    }
);

$('.select-2-enable')
.val(
    function(){
        $(this)
        .children('.select2-selected')
        .attr('selected', 'selected');
        
        return $(this).val();
    }
)
.trigger('change');

axios.defaults.headers.common['X-Requested-With'] = "XMLHttpRequest";

const router = new VueRouter
.createRouter(
    {
        history: VueRouter.createWebHashHistory(),
        routes
    }
);

router.beforeEach(
    (to, from, next) => {
        if(to.name == 'SignIn' || to.name == 'SignUp'){
            if(store.state.user)
                next({ name: 'Dashboard'});
            else
                next();
        }
        else{
            if(to.meta.isAuth){
                if(store.state.user)
                    next();
                else
                    next({ name: 'SignIn'});
            }
            else{
                next();
            }
        }
    }
)

const app = Vue.createApp(
    {
        data(){
            return {
                state: {},
                $state: store.state
            }
        },
        mounted(){
            if(user)
                store.set('user', user)
        }
    }
);
app.use(router);

app.mount("#app");