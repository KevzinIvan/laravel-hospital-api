
<script setup>
import { ref } from 'vue'
import Login from './Login.vue'
import Dashboard from './Dashboard.vue'

const token = ref('')

</script>

<template>
  <Login v-if="!token" @login="token = $event" />
  <Dashboard v-else :token="token" @logout="token = ''" />
</template>
