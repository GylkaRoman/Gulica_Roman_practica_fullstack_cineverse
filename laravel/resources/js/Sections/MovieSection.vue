<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'

const movie = ref(null)

const page = usePage()
const movieId = page.url.split('/').pop()

onMounted(async () => {
    try {
        const res = await axios.get(`/api/movies/${movieId}`)
        movie.value = res.data
    } catch (e) {
        console.error(e)
    }
})
</script>

<template>
    <div v-if="movie" class="text-white bg-gray-950 min-h-screen font-space">

        <div class="max-w-6xl mx-auto p-10 grid grid-cols-2 gap-10 items-center">

            <img :src="movie.poster_url" class="w-full max-w-sm rounded-2xl shadow-xl" />

            <div>

                <h1 class="text-5xl font-bold text-primary mb-4">
                    {{ movie.title }}
                </h1>

                <p class="text-gray-300 mb-6">
                    {{ movie.description }}
                </p>

                <div class="space-y-2 text-gray-300">

                    <p><span class="text-primary">Original:</span> {{ movie.original_title }}</p>
                    <p><span class="text-primary">Genre:</span> {{ movie.genre }}</p>
                    <p><span class="text-primary">Duration:</span> {{ movie.duration }} min</p>
                    <p><span class="text-primary">Age:</span> {{ movie.age_rating }}</p>
                    <p><span class="text-primary">Director:</span> {{ movie.director }}</p>
                    <p><span class="text-primary">Actors:</span> {{ movie.actors }}</p>

                </div>

                <a :href="movie.trailer_url" target="_blank" class="inline-block mt-6 bg-primary text-black px-6 py-3 rounded-lg font-bold hover:bg-white hover:text-black transition duration-300">
                    Watch Trailer
                </a>

            </div>

        </div>

    </div>
</template>