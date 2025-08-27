import { createRouter, createWebHistory } from 'vue-router'
import Auth from '@/views/Auth.vue'
import HomeView from '../views/HomeView.vue'
import BilanView from '../views/BilanView.vue'
import AjoutLoc from '@/views/AjoutLoc.vue'

const routes = [
  {
    path: '/AuthLogin',
    name: 'Login',
    component: Auth
  }
  ,
  {
    path: '/home',
    name: 'Home',
    component: HomeView,
    meta: {requiresAuth: true}
  },
  {
    path: '/',
    name: 'Bilan',
    component: BilanView,
    meta: {requiresAuth: true}
  },
  {
    path: '/AjoutLocation',
    name: 'Ajout',
    component: AjoutLoc,
    meta: {requiresAuth: true}
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('auth') === 'true'
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/AuthLogin')
  } else if (to.path === '/AuthLogin' && isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
