import { createWebHistory, createRouter } from 'vue-router'
import EmailVerification from '../components/email/emailVerification.vue';
import AuthView from '../components/pages/auth.vue';
import DashboardView from '../components/pages/dashboard.vue';
import LoginView from '../components/login.vue';
import RegisterView from '../components/register.vue';

const routes = [
  { 
    path: '/', 
    component: AuthView,
    children:[
      {
        path: '',
        name: 'LoginView',
        component: LoginView
      }
      ,{
        path: 'register',
        name: 'RegisterView',
        component: RegisterView
      }
    ]
  },
  {
    path: '/dashboard',
    name: 'DashboardView',
    component: DashboardView,
    meta: { requiresAuth: true },
  },
  {
    path: '/email-verfication',
    name: 'EmailVerification',
    component: EmailVerification
  },
  {
    path: '/email-verification-failed',
    name: 'EmailVerificationFailed',
    component: () => import('@/components/email/emailVerificationFailed.vue')
  },
  {
    path: '/email-verification-expired',
    name: 'EmailVerificationExpired',
    component: () => import('@/components/email/emailVerificationExpired.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  
  const token = localStorage.getItem('auth_token');

  if (to.meta.requiresAuth && !token) {
    return next({ name: 'LoginView' }); // force guests to login
  }

  if ((to.name === 'LoginView' || to.name === 'RegisterView') && token) {
    return next({ name: 'DashboardView' }); // redirect logged-in users to dashboard
  }

  next();
});

export default router