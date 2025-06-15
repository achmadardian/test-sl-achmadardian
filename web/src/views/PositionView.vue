<script setup lang="ts">
import api from '@/services/axios'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const positionData = ref<{ id: number; name: number }[]>([])
const getPositions = async () => {
  try {
    const positions = await api.get('/positions')

    positionData.value = positions.data.data
  } catch (error: any) {
    console.error(error)
  }
}

const deletePosition = async (id: number) => {
  try {
    await api.delete(`/positions/${id}`)

    getPositions()
  } catch (error) {
    console.error(error)
  }
}

getPositions()
</script>

<template>
  <h1 class="pb-7">Positions</h1>
  <button
    class="p-3 bg-sky-300 rounded-sm hover:bg-sky-500 text-white transition-all duration-300"
    @click="router.push('/positions/create')"
  >
    Add Position
  </button>

  <div class="border border-black rounded-xl overflow-hidden">
    <table class="table-auto w-full border-spacing-2">
      <thead>
        <tr>
          <th class="p-1 border-b border-black">ID</th>
          <th class="p-1 border-b">Name</th>
          <th class="p-1 border-b">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="position in positionData"
          :key="position.id"
          class="even:bg-gray-100 odd:bg-white"
        >
          <td class="text-center border-">{{ position.id }}</td>
          <td class="text-center">{{ position.name }}</td>
          <td class="text-center flex flex-row gap-2 w-full justify-center">
            <button
              class="p-3 m-2 bg-sky-400 rounded-md text-white hover:bg-sky-600 transition-all duration-300"
              @click="router.push(`/positions/update?id=${position.id}&name=${position.name}`)"
            >
              Edit
            </button>
            <button
              class="p-3 m-2 bg-red-400 rounded-md text-black hover:bg-red-600 transition-all duration-300"
              @click="deletePosition(position.id)"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
