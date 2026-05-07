<script setup>
import { ref, onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { Link } from "@inertiajs/vue3";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

const sessions = ref([]);
const loaded = ref(false);

onMounted(async () => {
    try {
        const res = await fetch("/api/sessions");
        const data = await res.json();
        sessions.value = data.data ?? [];
    } finally {
        loaded.value = true;
    }
});
</script>

<template>
    <section class="container mx-auto px-3 sm:px-5 md:px-8 mt-10">
        <div
            class="flex flex-wrap bg-gray-950 px-4 py-4 rounded-lg mb-6 text-xl sm:text-2xl lg:text-3xl font-orbitron text-primary"
        >
            Now at the cinema
        </div>

        <Swiper
            v-if="loaded && sessions.length"
            :modules="[Autoplay, Navigation, Pagination]"
            :space-between="20"
            :loop="sessions.length > 1"
            :autoplay="{ delay: 4000, disableOnInteraction: true }"
            :navigation="true"
            :pagination="{ clickable: true }"
            :breakpoints="{
                0: { slidesPerView: 2 },
                450: { slidesPerView: 3 },
            }"
            class="pb-14"
        >
            <SwiperSlide v-for="session in sessions" :key="session.id">
                <Link
                    v-if="session.movie"
                    :href="`/movie/${session.movie.id}`"
                    class="block h-full"
                >
                    <article
                        class="relative w-full overflow-hidden rounded-2xl cursor-pointer group h-[450px] max-[1000px]:h-[250px] max-[450px]:h-[200px]"
                    >
                        <img
                            :src="session.movie.poster_url"
                            :alt="session.movie.title"
                            loading="lazy"
                            class="absolute inset-0 w-full h-full object-cover transition duration-500 group-hover:scale-105"
                        />

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"
                        ></div>

                        <div
                            class="absolute inset-0 flex flex-col justify-end p-6 max-[1000px]:p-4 max-[450px]:p-3"
                        >
                            <h2
                                class="font-orbitron text-primary text-2xl max-[1000px]:text-lg max-[600px]:text-sm max-[550px]:text-[10px]"
                            >
                                {{ session.movie.title }}
                            </h2>

                            <p
                                class="text-white/80 mt-1 text-sm max-[550px]:text-[10px]"
                            >
                                {{ session.date }} /
                                {{ session.time.slice(0, 5) }}
                            </p>
                        </div>
                    </article>
                </Link>
            </SwiperSlide>
        </Swiper>
    </section>
</template>
