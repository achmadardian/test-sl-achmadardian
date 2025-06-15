<script setup lang="ts">
import api from '@/services/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const err = ref<string>('')

const logout = async () => {
  try {
    await api.get('/auth/logout')

    localStorage.removeItem('access_token')
    localStorage.removeItem('user')

    router.push('/login')
  } catch (error: any) {
    if (error.response) {
      err.value = error.response.data.message || 'Something went wrong...'
    } else {
      err.value = 'Something went wrong'
    }
  }
}
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white p-5 space-y-4">
      <h2 class="text-xl font-bold mb-9">Menu</h2>

      <router-link
        to="/positions"
        class="block px-3 py-2 rounded hover:bg-gray-700"
        active-class="bg-gray-700"
      >
        Positions
      </router-link>

      <router-link
        to="/employees"
        class="block px-3 py-2 rounded hover:bg-gray-700"
        active-class="bg-gray-700"
      >
        Employees
      </router-link>

      <button @click="logout" class="block px-3 py-2 rounded hover:bg-gray-700 text-left w-full">
        Logout
      </button>
    </aside>

    <!-- Content area -->
    <main class="flex-1 bg-gray-100 p-6 overflow-auto">
      <router-view />
    </main>
  </div>
</template>
