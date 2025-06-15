<script setup lang="ts">
import api from '@/services/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const email = ref<string>('')
const password = ref<string>('')
const errMessage = ref<string>('')
const errValidation = ref<{ [key: string]: string[] }>({})

const login = async (email: string, password: string) => {
  try {
    const response = await api.post('/auth/login', {
      email: email,
      password: password,
    })

    const { access_token, user } = response.data.data

    localStorage.setItem('access_token', access_token)
    localStorage.setItem('user', JSON.stringify(user))

    console.info(response.data)

    router.push('/home')
  } catch (error: any) {
    if (error.response) {
      const status = error.response.status

      if (status === 401) {
        errMessage.value = error.response.data.message
      } else if (status === 422) {
        errValidation.value = error.response.data.errors
      } else {
        errMessage.value = 'Something went wrong...'
      }
    } else {
      errMessage.value = 'Something went wrong...'
    }
  }
}
</script>

<template>
  <div class="flex flex-col justify-center items-center h-screen">
    <form
      class="w-[600px] flex flex-col gap-2 p-5 border-1 border-black rounded-2xl"
      @submit.prevent
    >
      <h1 class="text-center text-3xl pb-5">Employee Management</h1>

      <!-- error message -->
      <div
        v-if="errMessage"
        class="bg-red-100 text-red-600 rounded-md px-4 py-2 text-sm text-center mb-3"
      >
        {{ errMessage }}
      </div>

      <fieldset class="flex flex-col">
        <legend class="text-sm pb-3">Email</legend>
        <input
          type="text"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter email here..."
          v-model="email"
          required
        />
        <ul v-if="errValidation.email" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.email" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <fieldset class="flex flex-col">
        <legend class="text-sm pb-3">Password</legend>
        <input
          type="password"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter password here..."
          v-model="password"
          required
        />
      </fieldset>
      <div class="pt-5 w-full">
        <button
          type="submit"
          :disabled="!email || !password"
          class="bg-sky-400 p-5 rounded-2xl text-white hover:bg-sky-600 transition-all duration-400 w-full"
          @click="login(email, password)"
        >
          Login
        </button>
      </div>
    </form>
  </div>
</template>
