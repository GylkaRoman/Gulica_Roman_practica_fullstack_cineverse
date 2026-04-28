<template>
  <div class="min-h-screen flex flex-col">

    <Navbar />

    <main class=" flex-1 container mx-auto">
      <slot />
    </main>

    <Footer />

  </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue'
import Footer from '@/Components/Footer.vue'
</script>