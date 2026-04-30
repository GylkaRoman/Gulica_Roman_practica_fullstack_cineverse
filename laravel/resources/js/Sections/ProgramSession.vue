<script setup>
import { ref, computed, onMounted } from 'vue'

const sessions = ref([])

const selectedDate = ref('')
const selectedGenre = ref('')
const selectedLanguage = ref('')

const fetchSessions = async () => {
    const res = await fetch('/api/sessions')
    const data = await res.json()
    return data.data
}

const availableDates = computed(() => {
    const set = new Set(sessions.value.map(s => s.date))
    return Array.from(set).sort()
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
const genres = computed(() => {
    const set = new Set(sessions.value.map(s => s.movie.genre))
    return Array.from(set)
})

const languages = computed(() => {
    const set = new Set(sessions.value.map(s => s.language))
    return Array.from(set)
})

</script>

<template>
    <div class="container px-8 mt-10 text-black font-bold font-space">

        <div class="flex gap-4 mb-8 flex-wrap bg-black px-5 py-5 rounded-lg">
            <select v-model="selectedDate" class="p-2 bg-primary rounded">
                <option value="">All dates</option>
                <option v-for="d in availableDates" :key="d" :value="d">
                    {{ d }}
                </option>
            </select>

            <select v-model="selectedGenre" class="p-2 bg-primary rounded">
                <option value="">All genres</option>

                <option v-for="g in genres" :key="g" :value="g">
                    {{ g }}
                </option>
            </select>

            <select v-model="selectedLanguage" class="p-2 bg-primary rounded">
                <option value="">All languages</option>

                <option v-for="l in languages" :key="l" :value="l">
                    {{ l.toUpperCase() }}
                </option>
            </select>

        </div>

        <div v-if="groupedMovies.length" class="grid lg:grid-cols-4 gap-6">

            <div v-for="item in groupedMovies" :key="item.movie.id"
                class="bg-primary rounded-2xl overflow-hidden shadow-lg">

                <div class="relative h-[300px]">
                    <img :src="item.movie.poster_url" class=" w-full h-full" />

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>

                    <div class="absolute bottom-3 left-3 right-3">
                        <h2 class="text-lg font-bold text-primary">
                            {{ item.movie.title }}
                        </h2>
                    </div>
                </div>

                <div class="p-4">

                    <p class="mb-3">
                        {{ item.movie.genre }}
                    </p>

                    <p class="mb-3">
                        {{ formatDuration(item.movie.duration) }}
                    </p>

                    <div class="flex flex-col gap-2">

                        <div v-for="s in item.sessions" :key="s.id" class=" bg-amber-500 p-2 rounded">
                            <div class="">
                                {{ s.date }} | {{ s.time.slice(0, 5) }}
                            </div>

                            <div class="">
                                {{ s.hall.name }} | {{ s.format }} | {{ s.language.toUpperCase() }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>