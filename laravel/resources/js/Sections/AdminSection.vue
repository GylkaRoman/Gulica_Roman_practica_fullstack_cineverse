<script setup>
import { router } from '@inertiajs/vue3'
</script>

<template>
<div class="min-h-screen bg-gray-950 text-white p-10">

    <h1 class="text-3xl mb-10 text-primary text-center">
        Admin Panel
    </h1>

    <div class="grid grid-cols-2 gap-6 max-w-2xl mx-auto text-black">

        <button
            @click="router.visit('/admin/movies')"
            class="bg-primary p-6 rounded text-xl hover: transition"
        >
            Movies
        </button>

        <button
            @click="router.visit('/admin/halls')"
            class="bg-primary p-6 rounded text-xl hover: transition"
        >
            Halls
        </button>

        <button
            @click="router.visit('/admin/sessions')"
            class="bg-primary p-6 rounded text-xl hover: transition"
        >
            Sessions
        </button>

        <button
            @click="router.visit('/admin/bookings')"
            class="bg-primary p-6 rounded text-xl hover: transition"
        >
            Bookings
        </button>

    </div>

</div>
</template>