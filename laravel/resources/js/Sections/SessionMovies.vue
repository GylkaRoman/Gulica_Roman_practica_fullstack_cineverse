<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

const sessions = ref([])

onMounted(async () => {
  const res = await fetch('/api/sessions')
  const data = await res.json()
  sessions.value = data.data ?? []
})
</script>

<template>
  <div class="container px-8 mt-10">

    <div class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6">
      Now at the cinema
    </div>

    <Swiper v-if="sessions.length" :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="4"
      :space-between="20" :loop="sessions.length > 1" :autoplay="{ delay: 4000 }" :navigation="true"
      :pagination="{ clickable: true }" class="h-[490px]">

      <SwiperSlide v-for="session in sessions" :key="session.id">

        <div class="relative h-[450px] w-full text-white overflow-hidden rounded-2xl">

          <img :src="session.movie.poster_url" class="absolute inset-0 object-cover" />

          <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

          <div class="absolute inset-0 flex items-end">

            <div class="p-6">

              <h1 class="text-2xl font-orbitron text-primary">
                {{ session.movie.title }}
              </h1>

              <p class="text-sm mt-1">
                {{ session.date }} / {{ session.time.slice(0, 5) }}
              </p>

            </div>

          </div>

        </div>

      </SwiperSlide>

    </Swiper>

  </div>
</template>