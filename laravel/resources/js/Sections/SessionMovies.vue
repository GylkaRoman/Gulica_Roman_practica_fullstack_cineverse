<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'
import { Link } from '@inertiajs/vue3'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

const sessions = ref([])

const loaded = ref(false)

onMounted(async () => {
  try {
    const res = await fetch('/api/sessions')
    const data = await res.json()
    sessions.value = data.data ?? []
  } finally {
    loaded.value = true
  }
})
</script>

<template>
  <div class="container px-8 mt-10">

    <div class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6">
      Now at the cinema
    </div>

    <Swiper v-if="loaded && sessions.length" :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="4"
      :space-between="20" :loop="sessions.length > 1" :autoplay="{ delay: 4000, disableOnInteraction: true }"
      :navigation="true" :pagination="{ clickable: true }" class="h-[490px]">

      <SwiperSlide v-for="session in sessions" :key="session.id">

        <Link v-if="session.movie" :href="`/movie/${session.movie.id}`" class="block"
          :aria-label="`Open movie ${session.movie.title}`">

          <div class="relative h-[450px] w-full overflow-hidden rounded-2xl cursor-pointer">

            <img :src="session.movie.poster_url" :alt="session.movie.title" loading="lazy" decoding="async" width="300"
              height="450" class="absolute inset-0 w-full h-full object-cover" />

            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

            <div class="absolute inset-0 flex items-end">

              <div class="p-6">

                <h2 class="text-2xl font-orbitron text-primary">
                  {{ session.movie.title }}
                </h2>

                <p class="text-sm mt-1 text-white/80">
                  {{ session.date }} / {{ session.time.slice(0, 5) }}
                </p>

              </div>

            </div>

          </div>

        </Link>

      </SwiperSlide>

    </Swiper>

  </div>
</template>