import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/LoginView.vue'
import Sidebar from '@/layouts/Sidebar.vue'
import HomeView from '@/views/HomeView.vue'
import PositionView from '@/views/PositionView.vue'
import CreatePositionView from '@/views/CreatePositionView.vue'
import EmployeeView from '@/views/EmployeeView.vue'
import CreateEmployeeView from '@/views/CreateEmployeeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login',
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { public: true },
    },
    {
      path: '/',
      component: Sidebar,
      children: [
        { path: 'home', component: HomeView },
        { path: '/positions', component: PositionView },
        { path: '/positions/create', component: CreatePositionView },
        { path: '/positions/update', component: CreatePositionView },
        { path: '/employees', component: EmployeeView },
        { path: '/employees/create', component: CreateEmployeeView },
        { path: '/employees/update', component: CreateEmployeeView },
      ],
    },
  ],
})

router.beforeEach((to, from, next) => {
  const accessToken = localStorage.getItem('access_token')

  if (to.meta.public) {
    return next()
  }

  if (!accessToken) {
    return next('/login')
  }

  next()
})

export default router
