import Vue from 'vue';
import VueRouter from 'vue-router'

import store from './store';

import SignIn from './pages/Landing/SignIn/SignIn';
import SignUp from './pages/Landing/SignUp/SignUp';
import Landing from './pages/Landing/Landing';
import Dashboard from './pages/Dashboard/Dashboard';

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
    }
  }
];
Vue.use(VueRouter);


const router = new VueRouter(
    {
      routes: routes,
      mode: 'hash'
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