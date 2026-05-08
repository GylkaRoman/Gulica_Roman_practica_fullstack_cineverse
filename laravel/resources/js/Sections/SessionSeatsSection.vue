<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from "vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const sessionId = page.props.sessionId;

const hall = ref(null);
const seats = ref([]);
const selectedSeats = ref([]);
const bookingId = ref(null);

const format = ref("2D");
const ticketType = ref("standard");

const prices = ref([]);
const paymentError = ref(null);

const token = localStorage.getItem("token");

axios.defaults.validateStatus = (status) => status < 500;

onMounted(async () => {
    const seatRes = await axios.get(`/api/sessions/${sessionId}/seats`);
    hall.value = seatRes.data.hall;
    seats.value = seatRes.data.seats;

    const priceRes = await axios.get("/api/prices");
    prices.value = priceRes.data;
});

onBeforeUnmount(async () => {
    if (!bookingId.value) return;

    try {
        await axios.delete(`/api/bookings/${bookingId.value}`, {
            headers: { Authorization: `Bearer ${token}` },
        });
    } catch (e) {
        console.log("cleanup failed");
    }
});

const toggleSeat = (seat) => {
    if (seat.is_booked) return;

    const index = selectedSeats.value.findIndex((s) => s.id === seat.id);

    if (index === -1) {
        selectedSeats.value.push(seat);
    } else {
        selectedSeats.value.splice(index, 1);
    }
};

const isSelected = (seat) => selectedSeats.value.some((s) => s.id === seat.id);

const getSeatPrice = (seat) => {
    const type = seat.type === "vip" ? "vip" : ticketType.value;

    const price = prices.value.find(
        (p) => p.type === type && p.format === format.value,
    );

    return price ? Number(price.price) : 0;
};

const totalPrice = computed(() =>
    selectedSeats.value.reduce((sum, seat) => {
        return sum + getSeatPrice(seat);
    }, 0),
);

const createBooking = async () => {
    if (!selectedSeats.value.length) return;

    const res = await axios.post(
        "/api/bookings",
        {
            session_id: sessionId,
            seat_ids: selectedSeats.value.map((s) => s.id),
            format: format.value,
            ticket_type: ticketType.value,
        },
        {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        },
    );

    bookingId.value = res.data.id;
    paymentError.value = null;
};

const payBooking = async () => {
    paymentError.value = null;

    const res = await axios.post(
        `/api/bookings/${bookingId.value}/pay`,
        {},
        {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        },
    );

    if (res.status === 400) {
        paymentError.value = res.data.error;
        return;
    }

    if (res.status === 200) {
        bookingId.value = null;
        selectedSeats.value = [];
    }
};

const cancelBooking = async () => {
    try {
        await axios.delete(`/api/bookings/${bookingId.value}`, {
            headers: { Authorization: `Bearer ${token}` },
        });

        bookingId.value = null;
        selectedSeats.value = [];
        paymentError.value = null;
    } catch (e) {
        console.error(e);
    }
};
</script>

<template>
    <div class="flex flex-col p-10 text-primary bg-gray-950 items-center">
        <h1 class="text-2xl mb-4">Hall: {{ hall?.name }}</h1>

        <div class="flex gap-4 mb-6">
            <select v-model="format" class="bg-gray-800 p-2 rounded">
                <option value="2D">2D</option>
                <option value="3D">3D</option>
            </select>

            <select v-model="ticketType" class="bg-gray-800 p-2 rounded">
                <option value="standard">Adult</option>
                <option value="student">Student</option>
                <option value="child">Child</option>
            </select>
        </div>

        <div
            class="grid gap-2"
            :style="{
                gridTemplateColumns: `repeat(${hall?.seats_per_row}, 40px)`,
            }"
        >
            <div
                v-for="seat in seats"
                :key="seat.id"
                @click="toggleSeat(seat)"
                class="w-10 h-10 flex items-center justify-center rounded cursor-pointer transition"
                :class="[
                    seat.is_booked
                        ? 'bg-red-600 cursor-not-allowed'
                        : isSelected(seat)
                          ? 'bg-yellow-400 text-black'
                          : seat.type === 'vip'
                            ? 'bg-purple-500'
                            : 'bg-green-500',
                ]"
            >
                {{ seat.number }}
            </div>
        </div>

        <div class="mt-6 text-center">
            <p>Selected: {{ selectedSeats.length }}</p>
            <p>Total: {{ totalPrice }} MDL</p>

            <button
                class="mt-4 bg-primary text-black px-4 py-2 rounded"
                @click="createBooking"
                :disabled="!selectedSeats.length || bookingId"
            >
                Create Booking
            </button>
        </div>

        <div
            v-if="bookingId"
            class="mt-6 p-4 bg-primary text-black rounded w-full max-w-md"
        >
            <p class="font-bold mb-2">Booking</p>

            <div v-if="paymentError" class="bg-red-600 text-white p-2 mb-2">
                {{ paymentError }}
            </div>

            <p>Format: {{ format }}</p>
            <p>Type: {{ ticketType }}</p>
            <p>Seats: {{ selectedSeats.length }}</p>
            <p class="font-bold">Total: {{ totalPrice }} MDL</p>

            <button
                class="w-full mt-3 bg-green-600 text-white py-2 rounded"
                @click="payBooking"
            >
                Pay
            </button>

            <button
                class="w-full mt-2 bg-red-600 text-white py-2 rounded"
                @click="cancelBooking"
            >
                Cancel
            </button>
        </div>
    </div>
</template>
