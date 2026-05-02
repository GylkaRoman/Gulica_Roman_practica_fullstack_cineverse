<script setup>
import { ref, onMounted } from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue'
import { Autoplay, Navigation, Pagination } from 'swiper/modules'
import { Link } from '@inertiajs/vue3'

import 'swiper/css'
import 'swiper/css/navigation'
import 'swiper/css/pagination'

const movies = ref([])
const sessions = ref([])
const soonMovies = ref([])

const fetchMovies = async () => {
    const res = await fetch('/api/movies')
    const data = await res.json()
    return data.data
}

const fetchSessions = async () => {
    const res = await fetch('/api/sessions')
    const data = await res.json()
    return data.data
}

onMounted(async () => {
    movies.value = await fetchMovies()
    sessions.value = await fetchSessions()

    const activeMovieIds = new Set(
        sessions.value.map(s => s.movie_id)
    )

    soonMovies.value = movies.value.filter(
        movie => !activeMovieIds.has(movie.id)
    )
})
</script>

<template>
    <div class="container px-8 mt-10">

        <div class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6">
            Soon in cinema
        </div>

        <Swiper v-if="soonMovies.length" :modules="[Autoplay, Navigation, Pagination]" :slides-per-view="3"
            :space-between="20" :loop="soonMovies.length > 1" :autoplay="{ delay: 4000 }" :navigation="true"
            :pagination="{ clickable: true }" class="h-[490px]">

            <SwiperSlide v-for="movie in soonMovies" :key="movie.id">

                <Link :href="`/movie/${movie.id}`" class="block">

                    <div class="relative h-[450px] overflow-hidden rounded-2xl 
                    cursor-pointer">

                        <img :src="movie.poster_url" class="absolute inset-0 w-full h-full" />

                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>

                        <div class="absolute inset-0 flex items-end">
                            <div class="p-6">
                                <h1 class="text-2xl font-orbitron text-primary">
                                    {{ movie.title }}
                                </h1>
                            </div>
                        </div>

                    </div>

                </Link>

            </SwiperSlide>

        </Swiper>

    </div>
</template>