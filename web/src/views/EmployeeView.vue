<script setup lang="ts">
import api from '@/services/axios'
import type { employeeType } from '@/types'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const employees = ref<employeeType[]>([])
const getEmployees = async () => {
  try {
    const employeeData = await api.get('/employees')
    employees.value = employeeData.data.data
  } catch (error) {
    console.error(error)
  }
}

const deleteEmployee = async (id: number) => {
  try {
    await api.delete(`/employees/${id}`)

    getEmployees()
  } catch (error) {
    console.log(error)
  }
}

getEmployees()
</script>

<template>
  <h1 class="pb-7">Employees</h1>
  <button
    class="p-3 bg-sky-300 rounded-sm hover:bg-sky-500 text-white transition-all duration-300"
    @click="router.push('/employees/create')"
  >
    Add Employees
  </button>

  <div class="border border-black rounded-xl overflow-hidden">
    <table class="table-auto w-full border-spacing-2">
      <thead>
        <tr>
          <th class="p-1 border-b border-black">ID</th>
          <th class="p-1 border-b">Name</th>
          <th class="p-1 border-b">Email</th>
          <th class="p-1 border-b">Hired At</th>
          <th class="p-1 border-b">Ended At</th>
          <th class="p-1 border-b">Position</th>
          <th class="p-1 border-b">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="employee in employees" :key="employee.id" class="even:bg-gray-100 odd:bg-white">
          <td class="text-center border-">{{ employee.id }}</td>
          <td class="text-center">{{ employee.name }}</td>
          <td class="text-center">{{ employee.email }}</td>
          <td class="text-center">{{ employee.hired_at }}</td>
          <td class="text-center">{{ employee.ended_at }}</td>
          <td class="text-center">{{ employee.position.name }}</td>
          <td class="text-center flex flex-row gap-3 w-full justify-center">
            <button
              class="p-3 m-2 bg-sky-400 rounded-md text-white hover:bg-sky-600 transition-all duration-300"
              @click="
                router.push(
                  `/employees/update?id=${employee.id}&name=${employee.name}&email=${employee.email}&hiredAt=${employee.hired_at}&endedAt=${employee.ended_at}&positionId=${employee.position.id}`,
                )
              "
            >
              Edit
            </button>
            <button
              class="p-3 m-2 bg-red-400 rounded-md text-black hover:bg-red-600 transition-all duration-300"
              @click="deleteEmployee(employee.id)"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
