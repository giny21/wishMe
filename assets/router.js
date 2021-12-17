import Vue from 'vue';
import VueRouter from 'vue-router'

import store from './store/store';

import SignIn from './pages/Landing/SignIn/SignIn.vue';
import SignUp from './pages/Landing/SignUp/SignUp.vue';
import Landing from './pages/Landing/Landing.vue';
import Dashboard from './pages/Dashboard/Dashboard.vue';
import Wishlists from './pages/Dashboard/Wishlists/Wishlists.vue';
import WishlistCreate from './pages/Dashboard/Wishlists/Create/Create.vue';
import WishlistEdit from './pages/Dashboard/Wishlists/Edit/Edit.vue';
import WishlistWishCreate from './pages/Dashboard/Wishlist/Wish/Create/Create.vue';
import WishlistSubscriptions from './pages/Dashboard/Wishlists/Subscriptions/Subscriptions.vue';
import Wishlist from './pages/Dashboard/Wishlist/Wishlist.vue';
import Wishes from './pages/Dashboard/Wishes/Wishes.vue';
import WishEdit from './pages/Dashboard/Wishes/Edit/Edit.vue';
import WishCreate from './pages/Dashboard/Wishes/Create/Create.vue';
import WishFields from './pages/Dashboard/Wishes/Fields/Fields.vue';
import WishLinks from './pages/Dashboard/Wishes/Links/Links.vue';
import WishSubscriptions from './pages/Dashboard/Wishes/Subscriptions/Subscriptions.vue';

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
        name: 'Wishlists',
        component: Wishlists,
        meta: { 
          requireAuth: true 
        },
        children: [
          {
            path: 'create',
            name: 'WishlistCreate',
            component: WishlistCreate,
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
      {
        path: '/list/:id',
        name: 'Wishlist',
        component: Wishlist,
        children: [
          {
            path: 'wish/create',
            name: 'WishlistWishCreate',
            component: WishlistWishCreate,
            meta: { 
              requireAuth: true 
            },
          }
        ]
      },
      {
        path: '/wish',
        name: 'Wishes',
        component: Wishes,
        meta: { 
          requireAuth: true 
        },
        children: [
          {
            path: 'create',
            name: 'WishCreate',
            component: WishCreate,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/edit',
            name: 'WishEdit',
            component: WishEdit,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/field',
            name: 'WishField',
            component: WishFields,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/link',
            name: 'WishLink',
            component: WishLinks,
            meta: { 
              requireAuth: true 
            },
          },
          {
            path: ':id/subscription',
            name: 'WishSubscription',
            component: WishSubscriptions,
            meta: { 
              requireAuth: true 
            },
          }
        ]
      }
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