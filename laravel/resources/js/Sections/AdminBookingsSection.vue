<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const bookings = ref([])
const search = ref('')
const status = ref('')
const token = localStorage.getItem('token')

const fetchBookings = async () => {
    const res = await axios.get('/api/admin/bookings', {
        headers: { Authorization: `Bearer ${token}` },
        params: {
            search: search.value,
            status: status.value
        }
    })

    bookings.value = res.data
}

onMounted(fetchBookings)
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-3xl bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                All Bookings
            </h1>

            <div class="flex gap-3 mb-6">

                <input v-model="search" placeholder="Search user"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <select v-model="status" class="p-3 bg-gray-800 rounded-lg text-white">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>

                <button @click="fetchBookings" class="bg-primary text-black px-4 py-3 rounded-lg font-bold">
                    Search
                </button>

            </div>

            <div v-for="b in bookings" :key="b.id" class="bg-gray-800 p-4 mb-3 rounded-lg">

                <p class="font-bold text-primary">
                    {{ b.user.name }}
                </p>

                <p class="text-sm text-gray-300">
                    {{ b.session.movie.title }} |
                    {{ b.status }} |
                    {{ b.total_price }} MDL
                </p>

            </div>

        </div>

    </div>
</template>