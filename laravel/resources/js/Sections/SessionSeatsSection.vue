<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import axios from 'axios'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const sessionId = page.props.sessionId

const hall = ref(null)
const seats = ref([])
const selectedSeats = ref([])
const bookingId = ref(null)

const format = ref('2D')
const ticketType = ref('standard')

const prices = ref([])

onMounted(async () => {
    const seatRes = await axios.get(`/api/sessions/${sessionId}/seats`)
    hall.value = seatRes.data.hall
    seats.value = seatRes.data.seats

    const priceRes = await axios.get('/api/prices')
    prices.value = priceRes.data
})

onBeforeUnmount(async () => {
    if (!bookingId.value) return

    try {
        await axios.delete(`/api/bookings/${bookingId.value}`)
    } catch (e) {
        console.log('cleanup failed')
    }
})

const toggleSeat = (seat) => {
    if (seat.is_booked) return

    const index = selectedSeats.value.findIndex(s => s.id === seat.id)

    if (index === -1) {
        selectedSeats.value.push(seat)
    } else {
        selectedSeats.value.splice(index, 1)
    }
}

const isSelected = (seat) => {
    return selectedSeats.value.some(s => s.id === seat.id)
}

const getSeatPrice = (seat) => {
    const seatType = seat.row === 1 ? 'vip' : ticketType.value

    const price = prices.value.find(p =>
        p.type === seatType &&
        p.format === format.value
    )

    return price ? Number(price.price) : 0
}

const totalPrice = computed(() => {
    return selectedSeats.value.reduce((sum, seat) => {
        return sum + getSeatPrice(seat)
    }, 0)
})

const createBooking = async () => {
    if (!selectedSeats.value.length) return

    const res = await axios.post('/api/bookings', {
        session_id: sessionId,
        seat_ids: selectedSeats.value.map(s => s.id),
        format: format.value,
        ticket_type: ticketType.value
    })

    bookingId.value = res.data.id
}

const payBooking = async () => {
    await axios.post(`/api/bookings/${bookingId.value}/pay`)

    alert('Paid successfully')

    bookingId.value = null
    selectedSeats.value = []
}

const cancelBooking = async () => {
    try {
        const token = localStorage.getItem('token')

        await axios.delete(`/api/bookings/${bookingId.value}`, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        bookingId.value = null
        selectedSeats.value = []

    } catch (e) {
        console.error('DELETE ERROR:', e)
    }
}
</script>

<template>
    <div class="flex flex-col  p-10 text-primary bg-gray-950 justify-center items-center">

        <h1 class="text-2xl mb-4">
            Hall: {{ hall?.name }}
        </h1>

        <div class="flex gap-4 mb-6">

            <select v-model="format" class="bg-primary text-gray-950 p-2 rounded cursor-pointer">
                <option value="2D">2D</option>
                <option value="3D">3D</option>
            </select>

            <select v-model="ticketType" class="bg-primary text-gray-950 p-2 rounded cursor-pointer">
                <option value="standard">Standard</option>
                <option value="student">Student</option>
                <option value="child">Child</option>
            </select>

        </div>
        <div class=" bg-primary text-black px-12 py-1 mb-5">Movie Chene</div>

        <div class="grid gap-2" :style="{ gridTemplateColumns: `repeat(${hall?.seats_per_row}, 40px)` }">
            <div v-for="seat in seats" :key="seat.id" @click="toggleSeat(seat)"
                class="w-10 h-10 flex items-center justify-center rounded cursor-pointer transition" :class="[
                    seat.is_booked
                        ? 'bg-red-600 cursor-not-allowed'
                        : isSelected(seat)
                            ? 'bg-yellow-400 text-black'
                            : seat.row === 1
                                ? 'bg-purple-500'
                                : 'bg-green-500'
                ]">
                {{ seat.number }}
            </div>
        </div>

        <div class="flex flex-col justify-center items-center mt-6 ">

            <p>Selected: {{ selectedSeats.length }}</p>
            <p>Total price: {{ totalPrice }} MDL</p>

            <button
                class="mt-4 bg-primary text-gray-950 px-4 py-2 rounded cursor-pointer hover:bg-red-600 transition hover:text-white"
                @click="createBooking" :disabled="!selectedSeats.length || bookingId">
                Create Booking
            </button>

            <div v-if="bookingId"
                class="flex flex-col justify-center items-center mt-6 p-4 bg-primary rounded text-black w-full">

                <p class="font-bold mb-3">
                    Booking Summary
                </p>

                <div class="w-full mb-3">
                    <p class="font-semibold">Seats:</p>

                    <div class="flex flex-wrap gap-2 mt-1">
                        <span v-for="s in selectedSeats" :key="s.id" class="px-2 py-1 bg-black text-white rounded">
                            Row {{ s.row }} - Seat {{ s.number }}
                        </span>
                    </div>
                </div>

                <div class="w-full mb-3 space-y-1">

                    <div class="flex justify-between">
                        <span>Format:</span>
                        <span>{{ format }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Ticket type:</span>
                        <span>{{ ticketType }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Seats count:</span>
                        <span>{{ selectedSeats.length }}</span>
                    </div>

                </div>

                <div class="w-full border-t border-black pt-2 mb-4">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total:</span>
                        <span>{{ totalPrice }} MDL</span>
                    </div>
                </div>

                <button class="w-full py-2 bg-green-600 text-white rounded mb-2 hover:bg-green-700 transition"
                    @click="payBooking">
                    Pay Now
                </button>

                <button class="w-full py-2 bg-red-600 text-white rounded hover:bg-red-700 transition"
                    @click="cancelBooking">
                    Cancel Booking
                </button>

            </div>

        </div>

    </div>
</template>