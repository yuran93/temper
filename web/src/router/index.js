import { createRouter, createWebHistory } from 'vue-router'
import WeeklyRetention from '../views/WeeklyRetention.vue'
import UpcaseRetention from '../views/UpcaseRetention.vue'

const routes = [
  {
    path: '/',
    name: 'WeeklyRetention',
    component: WeeklyRetention
  },
  {
    path: '/upcase',
    name: 'UpcaseRetention',
    component: UpcaseRetention
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
