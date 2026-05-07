<script setup>
import { router } from "@inertiajs/vue3";
</script>

<template>
    <main class="min-h-screen bg-gray-950 text-white px-4 sm:px-10 py-10">
        <h1
            class="text-2xl sm:text-3xl mb-10 text-primary text-center font-bold"
        >
            Admin Panel
        </h1>

        <div
            class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 max-w-2xl mx-auto"
        >
            <button
                @click="router.visit('/admin/movies')"
                class="bg-primary text-black p-5 sm:p-6 rounded-lg text-lg sm:text-xl font-bold hover:opacity-80 transition focus:outline-none focus:ring-2 focus:ring-primary"
            >
                Movies
            </button>

            <button
                @click="router.visit('/admin/halls')"
                class="bg-primary text-black p-5 sm:p-6 rounded-lg text-lg sm:text-xl font-bold hover:opacity-80 transition focus:outline-none focus:ring-2 focus:ring-primary"
            >
                Halls
            </button>

            <button
                @click="router.visit('/admin/sessions')"
                class="bg-primary text-black p-5 sm:p-6 rounded-lg text-lg sm:text-xl font-bold hover:opacity-80 transition focus:outline-none focus:ring-2 focus:ring-primary"
            >
                Sessions
            </button>

            <button
                @click="router.visit('/admin/bookings')"
                class="bg-primary text-black p-5 sm:p-6 rounded-lg text-lg sm:text-xl font-bold hover:opacity-80 transition focus:outline-none focus:ring-2 focus:ring-primary"
            >
                Bookings
            </button>
        </div>
    </main>
</template>
