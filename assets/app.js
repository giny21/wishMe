import './styles/app.scss';

import '@fortawesome/fontawesome-free/js/fontawesome'
import '@fortawesome/fontawesome-free/js/solid'
import '@fortawesome/fontawesome-free/js/regular'
import '@fortawesome/fontawesome-free/js/brands'
import 'select2';

import Vue from 'vue';
import store from './store';
import router from './router';
import axios from 'axios';
import { BootstrapVue } from 'bootstrap-vue'

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

const app = new Vue(
    {
        router,
        data(){
            return {
                state: {},
                $state: store.state
            }
        }
    }
).$mount("#app");

Vue.use(BootstrapVue);