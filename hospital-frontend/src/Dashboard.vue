
<script setup>
import { ref } from 'vue'
import './Dashboard.css'

const props = defineProps(['token'])
const emit = defineEmits(['logout'])

const API = 'http://127.0.0.1:8000/api'

const table = ref('patient')
const id = ref('')
const rows = ref([])
const columns = ref([])

async function getData() {
  let url = `/${table.value}`

  if (id.value.trim()) {
    url += `/${id.value.trim()}`
  }

  const res = await fetch(API + url, {
    method: 'GET',
    headers: {
      'Accept': 'application/json',
      Authorization: `Bearer ${props.token}`
    }
  })

  const json = await res.json()

  rows.value = Array.isArray(json.data)
    ? json.data
    : json.data ? [json.data] : []

  columns.value = rows.value.length
    ? Object.keys(rows.value[0])
    : []
}

function formatCell(value) {
  return typeof value === 'object' && value !== null
    ? JSON.stringify(value)
    : value ?? '-'
}
</script>

<template>
  <div class="dashboard">
    <header>
      <div>
        <h1>Hospital Dashboard</h1>
      </div>

      <button class="logout" @click="emit('logout')">Logout</button>
    </header>

    <br>

    <h2>CRUD Management</h2>

    <label>Select Table</label>
    <select v-model="table">
      <option value="doctor">Doctor</option>
      <option value="patient">Patient</option>
      <option value="billing">Billing</option>
      <option value="appointment">Appointment</option>
      <option value="staff">Staff</option>
      <option value="hospital_beds">Hospital Beds</option>
      <option value="treatments">Treatments</option>
      <option value="staff_schedules">Staff Schedules</option>
      <option value="treatment_categories">Treatment Categories</option>
      <option value="logs">Logs</option>
      <option value="user">User</option>
    </select>

    <label>ID</label>
    <input v-model="id" placeholder="Enter ID">

    <div class="actions">
      <button class="get" @click="getData">GET</button>
      <button class="post" disabled>POST</button>
      <button class="put" disabled>PUT</button>
      <button class="delete" disabled>DELETE</button>
    </div>

    <label>Response</label>

    <div class="table-container">
      <table v-if="rows.length">
        <thead>
          <tr>
            <th v-for="column in columns" :key="column">
              {{ column }}
            </th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="(row, index) in rows" :key="index">
            <td v-for="column in columns" :key="column">
              {{ formatCell(row[column]) }}
            </td>
          </tr>
        </tbody>
      </table>

      <p v-else>Data belum ditampilkan.</p>
    </div>
  </div>
</template>
