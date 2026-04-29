<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Navigation, Autoplay } from 'swiper/modules'

import 'swiper/css'
import 'swiper/css/navigation'

const movies = ref([])

onMounted(async () => {
  const res = await fetch('/api/movies')
  const data = await res.json()
  movies.value = data.data ?? []
})

const convertToEmbed = (url) => {
  if (!url) return ''
  const videoId = url.split('youtu.be/')[1]?.split('?')[0]

  return `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=1&controls=0&loop=1&playlist=${videoId}`
}
</script>

<template>
  <div class="container mx-auto px-6">

    <Swiper v-if="movies.length" :modules="[Navigation, Autoplay]" :slides-per-view="1" :loop="movies.length > 1"
      :navigation="true" :autoplay="{ delay: 20000 }" class="rounded-2xl overflow-hidden">

      <SwiperSlide v-for="movie in movies" :key="movie.id">

        <div class="relative h-[500px] w-full overflow-hidden bg-black rounded-2xl">

          <iframe class="absolute top-1/2 left-1/2 w-[170%] h-[170%] -translate-x-1/2 -translate-y-1/2"
            :src="convertToEmbed(movie.trailer_url)"></iframe>

          <a :href="movie.trailer_url" target="_blank" class="absolute inset-0 z-20"></a>

          <div class="absolute inset-0 bg-black/60 z-10"></div>

          <div class="absolute bottom-0 left-0 p-10 text-white z-30">
            <h1 class="text-3xl font-orbitron text-primary">
              {{ movie.title }}
            </h1>
          </div>

        </div>

      </SwiperSlide>

    </Swiper>

  </div>
</template>