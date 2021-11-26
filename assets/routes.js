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
      isAuth: true 
    }
  }
];

export default routes;