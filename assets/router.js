import Vue from 'vue';
import VueRouter from 'vue-router'

import store from './store/store';

import SignIn from './pages/Landing/SignIn/SignIn.vue';
import SignUp from './pages/Landing/SignUp/SignUp.vue';
import Landing from './pages/Landing/Landing.vue';
import Dashboard from './pages/Dashboard/Dashboard.vue';
import Wishlists from './pages/Dashboard/Wishlists/Wishlists.vue'
import WishlistAdd from './pages/Dashboard/Wishlists/Add/Add.vue'
import WishlistEdit from './pages/Dashboard/Wishlists/Edit/Edit.vue'
import WishlistSubscriptions from './pages/Dashboard/Wishlists/Subscriptions/Subscriptions.vue'

const routes = [
  { 
    path: '/p', 
    component: Landing,
    children: [
      {
        path: '/sign-in',
        name: 'SignIn',
        component: SignIn
      },
      {
        path: '/sign-up',
        name: 'SignUp',
        component: SignUp
      }
    ]
  },
  { 
    path: '', 
    name: 'Dashboard',
    component: Dashboard,
    meta: { 
      requireAuth: true 
    },
    children: [
      {
        path: '/list',
        name: 'Wishlist',
        component: Wishlists,
        meta: { 
          requireAuth: true 
        },
        children: [
          {
            path: 'add',
            name: 'WishlistAdd',
            component: WishlistAdd,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/edit',
            name: 'WishlistEdit',
            component: WishlistEdit,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/subscription',
            name: 'WishlistSubscription',
            component: WishlistSubscriptions,
            meta: { 
              requireAuth: true 
            },
          }
        ]
      },
    ]
  }
];
Vue.use(VueRouter);


const router = new VueRouter(
    {
      routes: routes,
      mode: 'hash'
    },
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
            if(to.meta.requireAuth){
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

export default router;