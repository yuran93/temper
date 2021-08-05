import { createRouter, createWebHistory } from 'vue-router'
import WeeklyRetention from '../views/WeeklyRetention.vue'

const routes = [
  {
    path: '/',
    name: 'WeeklyRetention',
    component: WeeklyRetention
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
