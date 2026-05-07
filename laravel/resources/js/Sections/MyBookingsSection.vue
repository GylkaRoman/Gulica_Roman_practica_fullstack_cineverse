<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const bookings = ref([]);
const loadingId = ref(null);
const errors = ref({});

axios.defaults.validateStatus = (status) => {
    return status < 500;
};

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

    errors.value[id] = null;
    loadingId.value = id;

    try {
        const res = await axios.post(
            `/api/bookings/${id}/pay`,
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            },
        );

        if (res.status === 400) {
            errors.value[id] = res.data.error;
            return;
        }

        if (res.status === 200) {
            const booking = bookings.value.find((b) => b.id === id);

            if (booking) {
                booking.status = "paid";
            }

            errors.value[id] = null;
        }
    } catch (err) {
        errors.value[id] = err.response?.data?.error || "Payment failed";
    } finally {
        loadingId.value = null;
    }
};
</script>

<template>
    <div class="p-10 text-white">
        <div
            class="flex gap-4 flex-wrap bg-gray-950 px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6"
        >
            My Bookings
        </div>

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

            <div
                v-if="errors[b.id]"
                class="mt-2 p-2 bg-red-900/40 text-red-400 rounded"
            >
                {{ errors[b.id] }}
            </div>

            <button
                v-if="b.status === 'pending'"
                @click="pay(b.id)"
                class="mt-3 bg-green-500 px-4 py-2 rounded disabled:opacity-50"
                :disabled="loadingId === b.id"
            >
                {{ loadingId === b.id ? "Processing..." : "Pay" }}
            </button>
        </div>
    </div>
</template>
