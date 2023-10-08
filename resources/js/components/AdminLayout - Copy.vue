<script setup>
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
</script>

<template>
  <Sidebar />
  <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
    <!-- Navbar -->
      <Navbar />

      <div class="w-full px-6 py-6 mx-auto">
        <router-view></router-view>
      </div>
      
  </main>
</template>

