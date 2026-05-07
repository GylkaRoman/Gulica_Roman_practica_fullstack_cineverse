<script setup>
import { ref, computed, onMounted } from 'vue'
import { Link, Head } from '@inertiajs/vue3'

const sessions = ref([])

const selectedDate = ref('')
const selectedGenre = ref('')
const selectedLanguage = ref('')

const fetchSessions = async () => {
    const res = await fetch('/api/sessions')
    const data = await res.json()

    return data.data ?? []
}

const availableDates = computed(() => {
    const set = new Set(sessions.value.map(s => s.date))
    return Array.from(set).sort()
})

const genres = computed(() => {
    const set = new Set(sessions.value.map(s => s.movie.genre))
    return Array.from(set)
})

const languages = computed(() => {
    const set = new Set(sessions.value.map(s => s.language))
    return Array.from(set)
})

const formatDuration = (minutes) => {
    const h = Math.floor(minutes / 60)
    const m = minutes % 60

    return `${h}h ${m}m`
}

const filteredSessions = computed(() => {
    return sessions.value.filter(s => {
        return (
            (!selectedDate.value || s.date === selectedDate.value) &&
            (!selectedGenre.value || s.movie.genre === selectedGenre.value) &&
            (!selectedLanguage.value || s.language === selectedLanguage.value)
        )
    })
})

const groupedMovies = computed(() => {
    const map = new Map()

    filteredSessions.value.forEach(session => {
        const movieId = session.movie.id

        if (!map.has(movieId)) {
            map.set(movieId, {
                movie: session.movie,
                sessions: []
            })
        }

        map.get(movieId).sessions.push(session)
    })

    return Array.from(map.values())
})

onMounted(async () => {
    sessions.value = await fetchSessions()
})
</script>

<template>

    <section class="container px-8 mt-10 text-primary font-bold font-space" aria-label="Movie sessions">

        <div class="flex gap-4 mb-8 flex-wrap bg-gray-950 px-5 py-5 rounded-lg" aria-label="Movie filters">

            <label class="sr-only" for="date-filter">
                Filter by date
            </label>

            <select id="date-filter" v-model="selectedDate" class="p-2 bg-primary rounded text-gray-950">
                <option value="">All dates</option>

                <option v-for="d in availableDates" :key="d" :value="d">
                    {{ d }}
                </option>

            </select>

            <label class="sr-only" for="genre-filter">
                Filter by genre
            </label>

            <select id="genre-filter" v-model="selectedGenre" class="p-2 bg-primary rounded text-gray-950">
                <option value="">All genres</option>

                <option v-for="g in genres" :key="g" :value="g">
                    {{ g }}
                </option>

            </select>

            <label class="sr-only" for="language-filter">
                Filter by language
            </label>

            <select id="language-filter" v-model="selectedLanguage" class="p-2 bg-primary rounded text-gray-950">
                <option value="">All languages</option>

                <option v-for="l in languages" :key="l" :value="l">
                    {{ l.toUpperCase() }}
                </option>

            </select>

        </div>

        <div v-if="groupedMovies.length" class="grid lg:grid-cols-4 gap-6">

            <article v-for="item in groupedMovies" :key="item.movie.id"
                class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg">

                <Link :href="`/movie/${item.movie.id}`" :aria-label="`Open movie ${item.movie.title}`">

                    <div class="relative h-[300px] cursor-pointer group">

                        <img :src="item.movie.poster_url" :alt="`${item.movie.title} movie poster`" loading="lazy"
                            width="600" height="900"
                            class="w-full h-full object-cover group-hover:scale-105 transition" />

                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>

                        <div class="absolute bottom-3 left-3 right-3">

                            <h2 class="text-lg font-bold text-primary">
                                {{ item.movie.title }}
                            </h2>

                        </div>

                    </div>

                </Link>

                <div class="p-4">

                    <p class="mb-3">
                        Genre: {{ item.movie.genre }}
                    </p>

                    <p class="mb-3">
                        Duration: {{ formatDuration(item.movie.duration) }}
                    </p>

                    <div class="flex flex-col gap-2" aria-label="Movie sessions list">

                        <Link v-for="s in item.sessions" :key="s.id" :href="`/session/${s.id}`"
                            class="bg-gray-800 p-2 rounded hover:bg-primary hover:text-black transition cursor-pointer"
                            :aria-label="`Book session for ${item.movie.title} on ${s.date} at ${s.time}`">

                            <div>
                                {{ s.date }} | {{ s.time.slice(0, 5) }}
                            </div>

                            <div>
                                {{ s.hall.name }} |
                                {{ s.format }} |
                                {{ s.language.toUpperCase() }}
                            </div>

                        </Link>

                    </div>

                </div>

            </article>

        </div>

    </section>

</template>