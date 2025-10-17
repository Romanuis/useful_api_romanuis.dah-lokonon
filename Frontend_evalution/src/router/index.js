import { createRouter, createWebHistory } from 'vue-router'
import Login from '@/views/Login.vue'
import Register from '@/views/Register.vue'
import Dashboard from '@/views/Dashboard.vue'

const routes = [
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/dashboard', name: 'Dashboard', component: Dashboard, meta: { requiresAuth: true } }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Garde de navigation unique et corrigé
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')
  const isLoggedIn = !!token

  if (to.name === 'Login' && isLoggedIn) {
    next('/dashboard') // Évite de rester sur /login si connecté
  } else if (to.meta.requiresAuth && !isLoggedIn) {
    next('/login') // Protège les routes
  } else {
    next() // Continue
  }
})

export default router
