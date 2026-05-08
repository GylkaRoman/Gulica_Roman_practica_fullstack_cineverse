<script setup>
import { ref, onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { Link } from "@inertiajs/vue3";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const movies = ref([]);
const sessions = ref([]);
const soonMovies = ref([]);
const loading = ref(false);

const fetchMovies = async () => {
    const res = await fetch("/api/movies");
    const data = await res.json();
    return data.data ?? [];
};

const fetchSessions = async () => {
    const res = await fetch("/api/sessions");
    const data = await res.json();
    return data.data ?? [];
};

onMounted(async () => {
    loading.value = true;

    try {
        const [moviesData, sessionsData] = await Promise.all([
            fetchMovies(),
            fetchSessions(),
        ]);

        movies.value = moviesData;
        sessions.value = sessionsData;

        const activeMovieIds = new Set(sessions.value.map((s) => s.movie_id));

        soonMovies.value = movies.value.filter(
            (movie) => !activeMovieIds.has(movie.id),
        );
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <section class="container px-4 sm:px-6 lg:px-8 mt-10">
        <div class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg mb-6">
            <h2 class="font-orbitron text-primary text-2xl sm:text-3xl">
                Soon in cinema
            </h2>
        </div>

        <Swiper
            v-if="!loading && soonMovies.length"
            :modules="[Autoplay, Navigation, Pagination]"
            :space-between="20"
            :loop="soonMovies.length > 1"
            :autoplay="{
                delay: 4000,
                disableOnInteraction: true,
            }"
            :navigation="true"
            :pagination="{ clickable: true }"
            :breakpoints="{
                0: { slidesPerView: 2 },
                450: { slidesPerView: 3 },
            }"
            class="pb-14"
        >
            <SwiperSlide v-for="movie in soonMovies" :key="movie.id">
                <Link :href="`/movie/${movie.id}`" class="block h-full pb-14">
                    <article
                        class="relative w-full overflow-hidden rounded-2xl cursor-pointer group h-[450px] max-[1000px]:h-[250px] max-[450px]:h-[200px]"
                    >
                        <img
                            :src="movie.poster_url"
                            :alt="`${movie.title} poster`"
                            loading="lazy"
                            decoding="async"
                            width="300"
                            height="450"
                            class="absolute inset-0 w-full h-full transition duration-500 group-hover:scale-105"
                        />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"
                        ></div>

                        <div class="absolute inset-0 flex items-end">
                            <div class="p-4 sm:p-5 lg:p-6">
                                <h3
                                    class="font-orbitron text-primary text-2xl max-[1000px]:text-lg max-[550px]:text-[10px]"
                                >
                                    {{ movie.title }}
                                </h3>
                            </div>
                        </div>
                    </article>
                </Link>
            </SwiperSlide>
        </Swiper>
    </section>
</template>
