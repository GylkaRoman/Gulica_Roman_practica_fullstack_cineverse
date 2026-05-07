<script setup>
import { ref, computed, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const sessions = ref([]);

const selectedDate = ref("");
const selectedGenre = ref("");
const selectedLanguage = ref("");

const fetchSessions = async () => {
    const res = await fetch("/api/sessions");
    const data = await res.json();
    return data.data ?? [];
};

const availableDates = computed(() => {
    return [...new Set(sessions.value.map((s) => s.date))].sort();
});

const genres = computed(() => {
    return [...new Set(sessions.value.map((s) => s.movie.genre))];
});

const languages = computed(() => {
    return [...new Set(sessions.value.map((s) => s.language))];
});

const formatDuration = (minutes) => {
    const h = Math.floor(minutes / 60);
    const m = minutes % 60;
    return `${h}h ${m}m`;
};

const filteredSessions = computed(() => {
    return sessions.value.filter(
        (s) =>
            (!selectedDate.value || s.date === selectedDate.value) &&
            (!selectedGenre.value || s.movie.genre === selectedGenre.value) &&
            (!selectedLanguage.value || s.language === selectedLanguage.value),
    );
});

const groupedMovies = computed(() => {
    const map = new Map();

    filteredSessions.value.forEach((session) => {
        const id = session.movie.id;

        if (!map.has(id)) {
            map.set(id, { movie: session.movie, sessions: [] });
        }

        map.get(id).sessions.push(session);
    });

    return [...map.values()];
});

onMounted(async () => {
    sessions.value = await fetchSessions();
});
</script>

<template>
    <section
        class="container mx-auto px-4 sm:px-6 lg:px-8 mt-10 text-primary font-space"
    >
        <div
            class="flex flex-wrap bg-gray-950 px-4 py-4 rounded-lg mb-6 text-xl sm:text-2xl lg:text-3xl font-orbitron text-primary"
        >
            Movie sessions
        </div>

        <div
            class="flex flex-col sm:flex-row gap-3 sm:gap-4 bg-gray-950 p-4 sm:p-5 rounded-lg mb-8"
        >
            <select
                v-model="selectedDate"
                class="p-2 bg-primary rounded text-gray-950 w-full sm:w-auto"
            >
                <option value="">All dates</option>
                <option v-for="d in availableDates" :key="d" :value="d">
                    {{ d }}
                </option>
            </select>

            <select
                v-model="selectedGenre"
                class="p-2 bg-primary rounded text-gray-950 w-full sm:w-auto"
            >
                <option value="">All genres</option>
                <option v-for="g in genres" :key="g" :value="g">
                    {{ g }}
                </option>
            </select>

            <select
                v-model="selectedLanguage"
                class="p-2 bg-primary rounded text-gray-950 w-full sm:w-auto"
            >
                <option value="">All languages</option>
                <option v-for="l in languages" :key="l" :value="l">
                    {{ l.toUpperCase() }}
                </option>
            </select>
        </div>

        <div
            v-if="groupedMovies.length"
            class="grid gap-4 sm:gap-6 grid-cols-2 min-[400px]:grid-cols-3"
        >
            <article
                v-for="item in groupedMovies"
                :key="item.movie.id"
                class="bg-gray-950 rounded-2xl overflow-hidden shadow-lg"
            >
                <Link :href="`/movie/${item.movie.id}`">
                    <div
                        class="relative cursor-pointer group h-[150px] sm:h-[200px] lg:h-[270px]"
                    >
                        <img
                            :src="item.movie.poster_url"
                            :alt="`${item.movie.title} poster`"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition"
                        />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"
                        ></div>

                        <h2
                            class="absolute bottom-2 left-2 right-2 text-[11px] sm:text-sm lg:text-base font-bold text-primary"
                        >
                            {{ item.movie.title }}
                        </h2>
                    </div>
                </Link>

                <div class="p-2 sm:p-3 text-[10px] sm:text-sm">
                    <p>Genre: {{ item.movie.genre }}</p>
                    <p class="mb-2">
                        Duration: {{ formatDuration(item.movie.duration) }}
                    </p>

                    <div class="flex flex-col gap-2">
                        <Link
                            v-for="s in item.sessions"
                            :key="s.id"
                            :href="`/session/${s.id}`"
                            class="bg-gray-800 p-2 rounded hover:bg-primary hover:text-black transition"
                        >
                            <div class="text-[10px] sm:text-sm">
                                {{ s.date }} | {{ s.time.slice(0, 5) }}
                            </div>

                            <div class="text-[9px] sm:text-xs opacity-80">
                                {{ s.hall.name }} | {{ s.format }} |
                                {{ s.language.toUpperCase() }}
                            </div>
                        </Link>
                    </div>
                </div>
            </article>
        </div>
    </section>
</template>
