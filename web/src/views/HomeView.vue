<script setup lang="ts">
const user = JSON.parse(localStorage.getItem('user') || '{}')
</script>

<template>
  <div class="home">
    <h1 class="text-black-500">Welcome, {{ user.name }}</h1>
  </div>
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
