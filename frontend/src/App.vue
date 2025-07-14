<template>
  <div id="app">
    <nav class="bg-blue-600 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Municípios do Brasil</h1>
      </div>
    </nav>
    
    <main class="container mx-auto p-4">
      <RouterView />
    </main>
    
    <footer class="bg-gray-100 p-4 mt-8">
      <div class="container mx-auto text-center text-gray-600">
        <p>© 2025 API de Municípios - Todos os direitos reservados</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { RouterView } from 'vue-router'
</script>

<style>
@import 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css';

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

main {
  flex: 1;
}
</style>
