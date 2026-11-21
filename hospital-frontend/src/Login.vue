
<script setup>
import { ref } from 'vue'
import './Login.css'

const API = 'http://127.0.0.1:8000/api'

const username = ref('')
const password = ref('')

const emit = defineEmits(['login'])

async function login() {
  try {
    const res = await fetch(API + '/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        password: password.value
      })
    })

    const json = await res.json()

    if (!res.ok) {
      alert(json.error || 'Login gagal')
      return
    }

    emit('login', json.token)
  } catch {
    alert('Server tidak terhubung')
  }
}
</script>

<template>
  <div class="login">
    <div class="logo">
      <img src="./assets/logo.png" alt="Hospital Logo">
    </div>

    <div class="login-form">
      <h1>Hospital Login</h1>
      <p>Please login to continue</p>

      <label>Username</label>
      <input v-model="username" placeholder="Username">

      <label>Password</label>
      <input v-model="password" type="password" placeholder="Password">

      <button class="login-btn" @click="login">Login</button>
    </div>
  </div>
</template>
