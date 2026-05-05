<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const sessions = ref([])
const movies = ref([])
const halls = ref([])

const editingId = ref(null)
const token = localStorage.getItem('token')

const form = ref({
    movie_id: '',
    hall_id: '',
    date: '',
    time: '',
    format: '2D',
    language: 'en',
    base_price: 100
})

const fetchData = async () => {
    const [s, m, h] = await Promise.all([
        axios.get('/api/sessions'),
        axios.get('/api/movies'),
        axios.get('/api/halls')
    ])

    sessions.value = s.data.data ?? s.data ?? []
    movies.value = m.data.data ?? m.data ?? []
    halls.value = h.data.data ?? h.data ?? []
}

onMounted(fetchData)

const saveSession = async () => {
    try {
        if (editingId.value) {
            await axios.put(
                `/api/sessions/${editingId.value}`,
                form.value,
                {
                    headers: { Authorization: `Bearer ${token}` }
                }
            )
        } else {
            await axios.post(
                '/api/sessions',
                form.value,
                {
                    headers: { Authorization: `Bearer ${token}` }
                }
            )
        }

        resetForm()
        fetchData()

    } catch (e) {
        console.log('SESSION ERROR:', e.response?.data)
    }
}

const editSession = (s) => {
    editingId.value = s.id

    form.value = {
        movie_id: s.movie_id ?? s.movie?.id,
        hall_id: s.hall_id ?? s.hall?.id,
        date: s.date,
        time: s.time,
        format: s.format,
        language: s.language,
        base_price: s.base_price
    }
}

const deleteSession = async (id) => {
    await axios.delete(`/api/sessions/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    })

    fetchData()
}

const resetForm = () => {
    editingId.value = null

    form.value = {
        movie_id: '',
        hall_id: '',
        date: '',
        time: '',
        format: '2D',
        language: 'en',
        base_price: 100
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-3xl bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Sessions Admin
            </h1>

            <div class="grid grid-cols-2 gap-3 mb-6">

                <select v-model="form.movie_id"
                    class="w-full p-3 bg-gray-800 rounded-lg text-white outline-none focus:ring-2 focus:ring-primary">
                    <option disabled value="">Select movie</option>
                    <option v-for="m in movies" :key="m.id" :value="m.id">
                        {{ m.title }}
                    </option>
                </select>

                <select v-model="form.hall_id"
                    class="w-full p-3 bg-gray-800 rounded-lg text-white outline-none focus:ring-2 focus:ring-primary">
                    <option disabled value="">Select hall</option>
                    <option v-for="h in halls" :key="h.id" :value="h.id">
                        {{ h.name }}
                    </option>
                </select>

                <input v-model="form.date" type="date"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.time" type="time"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <select v-model="form.format" class="w-full p-3 bg-gray-800 rounded-lg text-white">
                    <option value="2D">2D</option>
                    <option value="3D">3D</option>
                </select>

                <select v-model="form.language" class="w-full p-3 bg-gray-800 rounded-lg text-white">
                    <option value="en">EN</option>
                    <option value="ru">RU</option>
                    <option value="ro">RO</option>
                </select>

                <input v-model="form.base_price" type="number"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary col-span-2" />

            </div>

            <button @click="saveSession"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition mb-6">
                {{ editingId ? 'Update Session' : 'Create Session' }}
            </button>

            <div v-for="s in sessions" :key="s.id"
                class="bg-gray-800 p-4 mb-3 rounded-lg flex justify-between items-center">

                <div>
                    <p class="font-bold text-primary">
                        {{ s.movie?.title }} : {{ s.hall?.name }}
                    </p>

                    <p class="text-sm text-gray-300">
                        {{ s.date }} {{ s.time }} |
                        {{ s.format }} |
                        {{ s.language }} |
                        {{ s.base_price }} MDL
                    </p>
                </div>

                <div class="flex gap-2">

                    <button @click="editSession(s)" class="bg-green-500 px-3 py-1 rounded text-black">
                        Edit
                    </button>

                    <button @click="deleteSession(s.id)" class="bg-red-500 px-3 py-1 rounded text-black">
                        Delete
                    </button>

                </div>

            </div>

        </div>

    </div>
</template>