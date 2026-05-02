<script setup>
import MainLayout from '@/Layouts/MainLayout.vue'

import HeroCarousel from '@/Sections/HeroCarousel.vue'
import SessionMovies from '@/Sections/SessionMovies.vue';
import SoonMovies from '@/Sections/SoonMovies.vue'

</script>

<template>
  <MainLayout>

    <HeroCarousel />
    <SessionMovies />
    <SoonMovies />

  </MainLayout>
</template>

<style>
.swiper-button-next,
.swiper-button-prev {
  color: #EFD915 !important;
  transform: scale(0.8);
}

.swiper-button-prev {
  left: 5px !important;
}

.swiper-button-next {
  right: 5px !important;
}

.swiper-pagination {
  bottom: 5px !important;
}

.swiper-pagination-bullet {
  width: 15px;
  height: 15px;
  background: white !important;
  opacity: 1 !important;
  border: 1px solid black;
}

.swiper-pagination-bullet-active {
  background: #EFD915 !important;
  opacity: 1;
}
</style>