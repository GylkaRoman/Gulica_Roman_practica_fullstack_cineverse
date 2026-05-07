<script setup>
import { ref, onMounted } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Autoplay } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";

const movies = ref([]);
const activeIndex = ref(0);

onMounted(async () => {
    const res = await fetch("/api/movies");
    const data = await res.json();

    movies.value = data.data ?? [];
});

const getVideoId = (url) => {
    if (!url) return "";

    return url.split("youtu.be/")[1]?.split("?")[0] || "";
};

const convertToEmbed = (url) => {
    const videoId = getVideoId(url);

    if (!videoId) return "";

    return `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1&mute=1&controls=0&loop=1&playlist=${videoId}&rel=0`;
};
</script>

<template>
    <section
        class="container mx-auto px-3 sm:px-4 md:px-6"
        aria-label="Movie trailers"
    >
        <Swiper
            v-if="movies.length"
            :modules="[Navigation, Autoplay]"
            :slides-per-view="1"
            :loop="movies.length > 1"
            :navigation="true"
            :autoplay="{ delay: 20000 }"
            class="rounded-2xl overflow-hidden"
            @slideChange="(swiper) => (activeIndex = swiper.realIndex)"
        >
            <SwiperSlide v-for="(movie, index) in movies" :key="movie.id">
                <div
                    class="relative h-[220px] sm:h-[320px] md:h-[420px] lg:h-[500px] w-full overflow-hidden bg-gray-950 rounded-2xl"
                >
                    <iframe
                        v-if="index === activeIndex"
                        class="absolute top-1/2 left-1/2 w-[260%] h-[260%] sm:w-[190%] sm:h-[190%] lg:w-[170%] lg:h-[170%] -translate-x-1/2 -translate-y-1/2"
                        :src="convertToEmbed(movie.trailer_url)"
                        :title="`Trailer for ${movie.title}`"
                        loading="eager"
                        allow="autoplay; encrypted-media"
                        allowfullscreen
                    ></iframe>

                    <img
                        v-else
                        :src="`https://img.youtube.com/vi/${getVideoId(movie.trailer_url)}/maxresdefault.jpg`"
                        :alt="`${movie.title} trailer preview`"
                        loading="lazy"
                        width="1280"
                        height="720"
                        class="absolute inset-0 w-full h-full object-cover"
                    />

                    <div class="absolute inset-0 bg-black/60 z-10"></div>

                    <a
                        :href="movie.trailer_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="absolute inset-0 z-20"
                        :aria-label="`Watch trailer for ${movie.title}`"
                    ></a>

                    <div
                        class="absolute bottom-0 left-0 p-4 sm:p-6 md:p-8 lg:p-10 text-white z-30"
                    >
                        <h2
                            class="font-orbitron text-primary text-xl sm:text-2xl md:text-3xl"
                        >
                            {{ movie.title }}
                        </h2>
                    </div>
                </div>
            </SwiperSlide>
        </Swiper>
    </section>
</template>
