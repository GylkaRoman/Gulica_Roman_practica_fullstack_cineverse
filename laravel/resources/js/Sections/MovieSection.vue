<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { usePage, Head } from "@inertiajs/vue3";

const movie = ref(null);

const page = usePage();
const movieId = page.url.split("/").pop();

onMounted(async () => {
    try {
        const res = await axios.get(`/api/movies/${movieId}`);
        movie.value = res.data;
    } catch (e) {
        console.error(e);
    }
});
</script>

<template>
    <main v-if="movie" class="text-white bg-gray-950 min-h-screen font-space">
        <section
            class="max-w-6xl mx-auto p-10 grid lg:grid-cols-2 gap-10 items-center"
        >
            <img
                :src="movie.poster_url"
                :alt="`${movie.title} movie poster`"
                loading="lazy"
                width="400"
                height="600"
                class="w-full max-w-sm rounded-2xl shadow-xl"
            />

            <article>
                <h1 class="text-5xl font-bold text-primary mb-4">
                    {{ movie.title }}
                </h1>

                <p class="text-gray-300 mb-6 leading-relaxed">
                    {{ movie.description }}
                </p>

                <div class="space-y-2 text-gray-300">
                    <p>
                        <span class="text-primary font-semibold">
                            Original:
                        </span>

                        {{ movie.original_title }}
                    </p>

                    <p>
                        <span class="text-primary font-semibold"> Genre: </span>

                        {{ movie.genre }}
                    </p>

                    <p>
                        <span class="text-primary font-semibold">
                            Duration:
                        </span>

                        {{ movie.duration }} min
                    </p>

                    <p>
                        <span class="text-primary font-semibold"> Age: </span>

                        {{ movie.age_rating }}
                    </p>

                    <p>
                        <span class="text-primary font-semibold">
                            Director:
                        </span>

                        {{ movie.director }}
                    </p>

                    <p>
                        <span class="text-primary font-semibold">
                            Actors:
                        </span>

                        {{ movie.actors }}
                    </p>
                </div>

                <a
                    :href="movie.trailer_url"
                    target="_blank"
                    rel="noopener noreferrer"
                    :aria-label="`Watch trailer for ${movie.title}`"
                    class="inline-block mt-6 bg-primary text-black px-6 py-3 rounded-lg font-bold hover:bg-white hover:text-black transition duration-300"
                >
                    Watch Trailer
                </a>
            </article>
        </section>
    </main>
</template>
