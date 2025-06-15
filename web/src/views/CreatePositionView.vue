<script setup lang="ts">
import { ref } from 'vue'
import api from '@/services/axios'
import { useRoute } from 'vue-router'
import router from '@/router'

const route = useRoute()
const errMessage = ref<string>('')
const errValidation = ref<{ [key: string]: string[] }>({})
const id = ref<number>(route.query && route.query.id ? Number(route.query.id) : 0)
const name = ref<string>(route.query && route.query.name ? String(route.query.name) : '')

const AddPosition = async (name: string) => {
  try {
    await api.post('/positions', {
      name: name,
    })

    router.back()
  } catch (error: any) {
    if (error.response) {
      const status = error.response.status

      if (status === 422) {
        errValidation.value = error.response.data.errors
      } else {
        errMessage.value = 'Something went wrong...'
      }
    } else {
      errMessage.value = 'Something went wrong...'
    }
  }
}

const UpdatePosition = async (id: number, name: string) => {
  try {
    await api.patch(`/positions/${id}`, {
      name: name,
    })

    router.back()
  } catch (error: any) {
    if (error.response) {
      const status = error.response.status

      if (status === 422) {
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
  <div class="flex justify-center items-center h-screen flex-col">
    <form class="w-[600px] flex flex-col gap-2 p-5rounded-2xl" @submit.prevent>
      <h1 class="text-center text-3xl pb-5">
        {{ id > 0 ? 'Update Position' : 'Add New Position' }}
      </h1>

      <!-- error message -->
      <div
        v-if="errMessage"
        class="bg-red-100 text-red-600 rounded-md px-4 py-2 text-sm text-center mb-3"
      >
        {{ errMessage }}
      </div>

      <fieldset class="flex flex-col">
        <legend class="text-lg pb-3">Position</legend>
        <input
          type="text"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter position here..."
          required
          v-model="name"
        />
        <ul v-if="errValidation.name" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.name" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <div class="pt-5 w-full">
        <button
          type="submit"
          :disabled="name.length === 0"
          class="bg-sky-400 p-5 rounded-2xl text-white hover:bg-sky-600 transition-all duration-400 w-full"
          @click="route.query && route.query.id ? UpdatePosition(id, name) : AddPosition(name)"
        >
          {{ id > 0 ? 'Update' : 'Save' }}
        </button>
      </div>
    </form>
  </div>
</template>
