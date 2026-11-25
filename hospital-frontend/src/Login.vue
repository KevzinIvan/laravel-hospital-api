<script src="./Login.js"></script>

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
