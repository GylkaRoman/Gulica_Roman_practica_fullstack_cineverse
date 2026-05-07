<script setup>
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

const user = ref(null);
const loading = ref(true);

const logout = async () => {
    try {
        const token = localStorage.getItem("token");

        await axios.post(
            "/api/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            },
        );
    } catch (e) {
        console.log("logout backend error (ignore)", e);
    }

    localStorage.removeItem("token");
    user.value = null;

    router.visit("/login");
};

onMounted(async () => {
    try {
        const token = localStorage.getItem("token");

        const res = await axios.get("/api/profile", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        user.value = res.data;
    } catch (e) {
        console.error("PROFILE ERROR:", e);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <main
        class="min-h-screen bg-black text-white px-4 sm:px-10 py-10 flex items-center justify-center"
    >
        <section
            class="w-full max-w-xl bg-gray-900 p-6 sm:p-8 rounded-2xl shadow-xl"
            aria-labelledby="profile-heading"
        >
            <h1
                id="profile-heading"
                class="text-2xl sm:text-3xl text-primary font-bold mb-6"
            >
                Profile
            </h1>

            <div v-if="loading" class="text-gray-400 text-sm">
                Loading profile...
            </div>

            <div v-else-if="user" class="space-y-4 sm:space-y-6">
                <p class="text-sm sm:text-lg">
                    <span class="text-primary font-semibold">Name:</span>
                    {{ user.name }}
                </p>

                <p class="text-sm sm:text-lg">
                    <span class="text-primary font-semibold">Email:</span>
                    {{ user.email }}
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6">
                    <button
                        type="button"
                        @click="router.visit('/my-bookings')"
                        class="bg-primary text-black px-5 py-3 rounded-lg font-bold hover:opacity-80 transition focus:outline-none focus:ring-2 focus:ring-primary"
                    >
                        My Bookings
                    </button>

                    <button
                        type="button"
                        @click="logout"
                        class="bg-red-500 text-white px-5 py-3 rounded-lg font-bold hover:bg-red-400 transition focus:outline-none focus:ring-2 focus:ring-red-500"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </section>
    </main>
</template>
