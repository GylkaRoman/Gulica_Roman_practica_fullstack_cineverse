<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const bookings = ref([]);

onMounted(async () => {
    const token = localStorage.getItem("token");

    const res = await axios.get("/api/user/bookings", {
        headers: {
            Authorization: `Bearer ${token}`,
        },
    });

    bookings.value = res.data;
});

const pay = async (id) => {
    const token = localStorage.getItem("token");

    await axios.post(
        `/api/bookings/${id}/pay`,
        {},
        {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        },
    );

    const booking = bookings.value.find((b) => b.id === id);
    if (booking) booking.status = "paid";
};
</script>

<template>
    <div class="p-10 text-white">
        <h1 class="text-2xl mb-6 text-primary">My Bookings</h1>

        <div v-if="bookings.length === 0">No bookings yet</div>

        <div
            v-for="b in bookings"
            :key="b.id"
            class="bg-gray-900 p-4 mb-4 rounded"
        >
            <p>Movie: {{ b.movie }}</p>
            <p>Date: {{ b.date }} | {{ b.time }}</p>
            <p>Hall: {{ b.hall }}</p>
            <p>
                Seats:
                {{ b.seats.map((s) => s.row + "-" + s.number).join(", ") }}
            </p>
            <p>Total: {{ b.total_price }} MDL</p>

            <p class="mt-2">
                Status:
                <span
                    :class="
                        b.status === 'paid'
                            ? 'text-green-400'
                            : 'text-yellow-400'
                    "
                >
                    {{ b.status }}
                </span>
            </p>

            <button
                v-if="b.status === 'pending'"
                @click="pay(b.id)"
                class="mt-3 bg-green-500 px-4 py-2 rounded"
            >
                Pay
            </button>
        </div>
    </div>
</template>
