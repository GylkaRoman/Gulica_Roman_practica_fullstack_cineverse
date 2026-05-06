<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const halls = ref([])
const editingId = ref(null)
const errors = ref({})

const token = localStorage.getItem('token')

const form = ref({
    name: '',
    rows_count: 5,
    seats_per_row: 5
})

const hasError = (field) => !!errors.value[field]

const clearError = (field) => {
    if (errors.value[field]) {
        delete errors.value[field]
    }
}

const fetchHalls = async () => {
    const res = await axios.get('/api/halls')
    halls.value = res.data.data ?? res.data ?? []
}

onMounted(fetchHalls)

const saveHall = async () => {
    errors.value = {}

    try {
        if (editingId.value) {
            await axios.put(`/api/halls/${editingId.value}`, form.value, {
                headers: { Authorization: `Bearer ${token}` }
            })
        } else {
            await axios.post('/api/halls', form.value, {
                headers: { Authorization: `Bearer ${token}` }
            })
        }

        resetForm()
        fetchHalls()

    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        } else if (e.response?.status === 401) {
            alert('Unauthorized')
        } else {
            console.log(e.response?.data)
        }
    }
}

const editHall = (hall) => {
    editingId.value = hall.id

    form.value = {
        name: hall.name,
        rows_count: hall.rows_count,
        seats_per_row: hall.seats_per_row
    }
}

const deleteHall = async (id) => {
    await axios.delete(`/api/halls/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    })

    fetchHalls()
}

const resetForm = () => {
    editingId.value = null
    errors.value = {}

    form.value = {
        name: '',
        rows_count: 5,
        seats_per_row: 5
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-2xl bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Admin Halls
            </h1>

            <div class="grid grid-cols-1 gap-4 mb-6">

                <div>
                    <input v-model="form.name" @input="clearError('name')" placeholder="Hall name" :class="[
                        'w-full p-3 rounded-lg outline-none',
                        hasError('name')
                            ? 'bg-gray-800 border border-red-500'
                            : 'bg-gray-800 focus:ring-2 focus:ring-primary'
                    ]" />
                    <p v-if="errors.name" class="text-red-500 text-sm mt-1">
                        {{ errors.name[0] }}
                    </p>
                </div>

                <div>
                    <input v-model="form.rows_count" @input="clearError('rows_count')" type="number" placeholder="Rows"
                        :class="[
                            'w-full p-3 rounded-lg outline-none',
                            hasError('rows_count')
                                ? 'bg-gray-800 border border-red-500'
                                : 'bg-gray-800 focus:ring-2 focus:ring-primary'
                        ]" />
                    <p v-if="errors.rows_count" class="text-red-500 text-sm mt-1">
                        {{ errors.rows_count[0] }}
                    </p>
                </div>

                <div>
                    <input v-model="form.seats_per_row" @input="clearError('seats_per_row')" type="number"
                        placeholder="Seats per row" :class="[
                            'w-full p-3 rounded-lg outline-none',
                            hasError('seats_per_row')
                                ? 'bg-gray-800 border border-red-500'
                                : 'bg-gray-800 focus:ring-2 focus:ring-primary'
                        ]" />
                    <p v-if="errors.seats_per_row" class="text-red-500 text-sm mt-1">
                        {{ errors.seats_per_row[0] }}
                    </p>
                </div>

            </div>

            <button @click="saveHall"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition mb-6">
                {{ editingId ? 'Update Hall' : 'Add Hall' }}
            </button>

            <div v-for="h in halls" :key="h.id"
                class="bg-gray-800 p-4 mb-3 rounded-lg flex justify-between items-center">

                <div>
                    <p class="font-bold text-primary">{{ h.name }}</p>
                    <p class="text-sm text-gray-300">
                        {{ h.rows_count }} rows × {{ h.seats_per_row }} seats
                    </p>
                </div>

                <div class="flex gap-2">
                    <button @click="editHall(h)" class="bg-green-500 px-3 py-1 rounded text-black">
                        Edit
                    </button>

                    <button @click="deleteHall(h.id)" class="bg-red-500 px-3 py-1 rounded text-black">
                        Delete
                    </button>
                </div>

            </div>

        </div>

    </div>
</template>