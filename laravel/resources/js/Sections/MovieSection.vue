<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { usePage, router, Head, Link } from "@inertiajs/vue3";

const page = usePage();

const movieId =
    page.props.movie?.id ||
    page.props.id ||
    page.url.split("/").filter(Boolean).pop();

const movie = ref(null);
const sessions = ref([]);

const fetchMovie = async () => {
    const res = await axios.get(`/api/movies/${movieId}`);
    movie.value = res.data;
};

const fetchSessions = async () => {
    const res = await axios.get("/api/sessions");
    sessions.value = res.data.data ?? [];
};

const movieSessions = computed(() => {
    return sessions.value.filter((s) => s.movie_id == movieId);
});

const groupedSessions = computed(() => {
    const map = new Map();

    movieSessions.value.forEach((s) => {
        if (!map.has(s.date)) {
            map.set(s.date, []);
        }
        map.get(s.date).push(s);
    });

    return Array.from(map.entries());
});

const buyTicket = (sessionId) => {
    const token = localStorage.getItem("token");

    if (!token) {
        router.visit("/login");
        return;
    }

    router.visit(`/session/${sessionId}`);
};

onMounted(async () => {
    await Promise.all([fetchMovie(), fetchSessions()]);
});
</script>

<template>
    <Head :title="movie?.title || 'Movie'" />

    <main v-if="movie" class="text-white bg-gray-950 min-h-screen font-space">
        <section
            class="max-w-6xl mx-auto p-10 grid lg:grid-cols-2 gap-10 items-start"
        >
            <img
                :src="movie.poster_url"
                :alt="movie.title"
                class="w-full max-w-sm rounded-2xl shadow-xl"
            />

            <article>
                <h1 class="text-4xl font-bold text-primary mb-4">
                    {{ movie.title }}
                </h1>

                <p class="text-gray-300 mb-6">
                    {{ movie.description }}
                </p>

                <div class="space-y-2 text-gray-300">
                    <p>
                        <span class="text-primary">Genre:</span>
                        {{ movie.genre }}
                    </p>
                    <p>
                        <span class="text-primary">Duration:</span>
                        {{ movie.duration }} min
                    </p>
                    <p>
                        <span class="text-primary">Age:</span>
                        {{ movie.age_rating }}
                    </p>
                    <p>
                        <span class="text-primary">Director:</span>
                        {{ movie.director }}
                    </p>
                    <p>
                        <span class="text-primary">Actors:</span>
                        {{ movie.actors }}
                    </p>
                </div>

                <div class="flex gap-4 mt-6">
                    <a
                        :href="movie.trailer_url"
                        target="_blank"
                        class="bg-gray-800 px-6 py-3 rounded font-bold hover:bg-white hover:text-black transition"
                    >
                        Watch Trailer
                    </a>
                </div>
            </article>
        </section>

        <section class="max-w-6xl mx-auto px-10 pb-20">
            <h2 class="text-2xl text-primary font-bold mb-6">
                Available Sessions
            </h2>

            <div v-if="groupedSessions.length" class="space-y-6">
                <div
                    v-for="[date, items] in groupedSessions"
                    :key="date"
                    class="bg-gray-900 rounded-xl p-4"
                >
                    <h3 class="text-white font-bold mb-3">
                        {{ date }}
                    </h3>

                    <div class="flex flex-col gap-3">
                        <div
                            v-for="s in items"
                            :key="s.id"
                            class="bg-gray-800 p-3 rounded flex flex-col sm:flex-row sm:items-center justify-between gap-2 hover:bg-gray-700 transition"
                        >
                            <div class="text-sm">
                                <div class="font-bold">
                                    {{ s.time.slice(0, 5) }}
                                </div>

                                <div class="text-xs opacity-80">
                                    {{ s.hall.name }} • {{ s.format }} •
                                    {{ s.language.toUpperCase() }}
                                </div>
                            </div>

                            <button
                                @click="buyTicket(s.id)"
                                class="bg-primary text-black px-4 py-2 rounded font-bold text-sm hover:bg-white transition"
                            >
                                Buy Ticket
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
