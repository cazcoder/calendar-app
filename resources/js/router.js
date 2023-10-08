import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore }  from './store/user'

const routes = [
  {
    path: '/',
    name: 'app.login',
    component: () => import('./views/Login.vue'),
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/',
    name: 'app.register',
    component: () => import('./views/Register.vue'),
    meta: {
      requiresGuest: true
    }
  },
  {
    path: '/admin',
    component: () => import('./components/AdminLayout.vue'),
    meta: {
      requiresAuth: true
    },
    children: [
      { path: '', name: 'app.dashboard', component: () => import('./views/Dashboard.vue') },
      { path: '/calendar', name: 'app.calendar', component: () => import('./views/Calendar.vue')},
      { path: '/profile', name: 'app.profile', component: () => import('./views/Profile.vue')}
    ],
  },
 
  // 404 not found
  {
    path: '/:catchAll(.*)*',
    component: () => import('./views/ErrorNotFound.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const store = useUserStore(); 
  if (to.meta.requiresAuth && !store.loggedIn) {
    next({name: 'app.login'})
  } else if (to.meta.requiresGuest && store.loggedIn) { 
    next({name: 'app.dashboard'})
  } else {
    next();
  }

}) 

export default router
