<script setup lang="ts">
import { ref } from 'vue'
import api from '@/services/axios'
import { useRoute } from 'vue-router'
import router from '@/router'
import type { positionType } from '@/types'

const formatDate = (date: Date): string => {
  return date.toISOString().split('T')[0]
}
const route = useRoute()
const errMessage = ref<string>('')
const errValidation = ref<{ [key: string]: string[] }>({})
const id = ref<number>(route.query && route.query.id ? Number(route.query.id) : 0)
const name = ref<string>(route.query && route.query.name ? String(route.query.name) : '')
const email = ref<string>(route.query && route.query.email ? String(route.query.email) : '')
const hiredAt = ref<string>(
  route.query?.hiredAt ? formatDate(new Date(String(route.query.hiredAt))) : '',
)
const endedAt = ref<string>(
  route.query?.endedAt ? formatDate(new Date(String(route.query.endedAt))) : '',
)

const positionId = ref<number>(
  route.query && route.query.positionId ? Number(route.query.positionId) : 0,
)
const positions = ref<positionType[]>([])

const AddEmployee = async (
  name: string,
  email: string,
  hiredAt: string,
  endedAt: string,
  positionId: number,
) => {
  try {
    await api.post('/employees', {
      name: name,
      email: email,
      hired_at: hiredAt,
      ended_at: endedAt,
      position_id: positionId,
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

const UpdateEmployee = async (
  id: number,
  name: string,
  email: string,
  hiredAt: string,
  endedAt: string,
  positionId: number,
) => {
  try {
    await api.patch(`/employees/${id}`, {
      name: name,
      email: email,
      hired_at: hiredAt,
      ended_at: endedAt,
      position_id: positionId,
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

const getPositions = async () => {
  try {
    const getPositions = await api.get('/positions')
    const data = getPositions.data.data as positionType[]

    if (id) positions.value = data
  } catch (error: any) {
    console.error(error)
  }
}

getPositions()
</script>

<template>
  <div class="flex justify-center items-center h-screen flex-col">
    <form class="w-[600px] flex flex-col gap-2 p-5rounded-2xl" @submit.prevent>
      <h1 class="text-center text-3xl pb-5">
        {{ id > 0 ? 'Update Employee' : 'Add New Employee' }}
      </h1>

      <!-- error message -->
      <div
        v-if="errMessage"
        class="bg-red-100 text-red-600 rounded-md px-4 py-2 text-sm text-center mb-3"
      >
        {{ errMessage }}
      </div>

      <fieldset class="flex flex-col">
        <legend class="text-lg pb-3">Name</legend>
        <input
          type="text"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter name here..."
          required
          v-model="name"
        />
        <ul v-if="errValidation.name" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.name" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <fieldset class="flex flex-col">
        <legend class="text-lg pb-3">Email</legend>
        <input
          type="text"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter emal here..."
          required
          v-model="email"
        />
        <ul v-if="errValidation.email" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.email" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <fieldset class="flex flex-col">
        <legend class="text-lg pb-3">Hired At</legend>
        <input
          type="date"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter hired at here..."
          required
          v-model="hiredAt"
        />
        <ul v-if="errValidation.hired_at" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.hired_at" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <fieldset class="flex flex-col">
        <legend class="text-lg pb-3">Ended At</legend>
        <input
          type="date"
          class="p-4 border-1 border-black rounded-2xl"
          placeholder="enter ended at here..."
          required
          v-model="endedAt"
        />
        <ul v-if="errValidation.ended_at" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.ended_at" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <fieldset class="flex flex-col" v-if="positions.length > 0">
        <legend class="text-lg pb-3">Position</legend>
        <select v-model="positionId">
          <option v-for="position in positions" :key="position.id" :value="position.id">
            {{ position.name }}
          </option>
        </select>
        <ul v-if="errValidation.position_id" class="text-red-500 text-sm mt-1 list-disc pl-5">
          <li v-for="(msg, index) in errValidation.name" :key="index">{{ msg }}</li>
        </ul>
      </fieldset>
      <div class="pt-5 w-full">
        <button
          type="submit"
          :disabled="name.length === 0"
          class="bg-sky-400 p-5 rounded-2xl text-white hover:bg-sky-600 transition-all duration-400 w-full"
          @click="
            route.query && id > 0
              ? UpdateEmployee(id, name, email, hiredAt, endedAt, positionId)
              : AddEmployee(name, email, hiredAt, endedAt, positionId)
          "
        >
          {{ id > 0 ? 'Update' : 'Save' }}
        </button>
      </div>
    </form>
  </div>
</template>
