<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const movies = ref([])
const editingId = ref(null)
const errors = ref({})

const token = localStorage.getItem('token')

const form = ref({
    title: '',
    original_title: '',
    description: '',
    poster_url: '',
    trailer_url: '',
    genre: '',
    duration: '',
    age_rating: '',
    director: '',
    actors: ''
})

const hasError = (field) => !!errors.value[field]

const clearError = (field) => {
    if (errors.value[field]) {
        delete errors.value[field]
    }
}

const fetchMovies = async () => {
    const res = await axios.get('/api/movies')
    movies.value = res.data.data ?? res.data
}

onMounted(fetchMovies)

const createMovie = async () => {
    errors.value = {}

    try {
        await axios.post('/api/movies', form.value, {
            headers: { Authorization: `Bearer ${token}` }
        })

        resetForm()
        fetchMovies()

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

const updateMovie = async () => {
    errors.value = {}

    try {
        await axios.put(`/api/movies/${editingId.value}`, form.value, {
            headers: { Authorization: `Bearer ${token}` }
        })

        resetForm()
        editingId.value = null
        fetchMovies()

    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        } else {
            console.log(e.response?.data)
        }
    }
}

const deleteMovie = async (id) => {
    await axios.delete(`/api/movies/${id}`, {
        headers: { Authorization: `Bearer ${token}` }
    })

    fetchMovies()
}

const startEdit = (movie) => {
    editingId.value = movie.id

    form.value = { ...movie }
}

const resetForm = () => {
    form.value = {
        title: '',
        original_title: '',
        description: '',
        poster_url: '',
        trailer_url: '',
        genre: '',
        duration: '',
        age_rating: '',
        director: '',
        actors: ''
    }

    errors.value = {}
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-3xl bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Movies Admin
            </h1>

            <div class="grid grid-cols-2 gap-4 mb-6">

                <div>
                    <input v-model="form.title" @input="clearError('title')" placeholder="Title"
                        :class="inputClass('title')" />
                    <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>
                </div>

                <div>
                    <input v-model="form.original_title" @input="clearError('original_title')"
                        placeholder="Original Title" :class="inputClass('original_title')" />
                    <p v-if="errors.original_title" class="error">{{ errors.original_title[0] }}</p>
                </div>

                <div>
                    <input v-model="form.genre" @input="clearError('genre')" placeholder="Genre"
                        :class="inputClass('genre')" />
                    <p v-if="errors.genre" class="error">{{ errors.genre[0] }}</p>
                </div>

                <div>
                    <input v-model="form.duration" @input="clearError('duration')" placeholder="Duration"
                        :class="inputClass('duration')" />
                    <p v-if="errors.duration" class="error">{{ errors.duration[0] }}</p>
                </div>

                <div>
                    <input v-model="form.age_rating" @input="clearError('age_rating')" placeholder="Age rating"
                        :class="inputClass('age_rating')" />
                    <p v-if="errors.age_rating" class="error">{{ errors.age_rating[0] }}</p>
                </div>

                <div>
                    <input v-model="form.director" @input="clearError('director')" placeholder="Director"
                        :class="inputClass('director')" />
                    <p v-if="errors.director" class="error">{{ errors.director[0] }}</p>
                </div>

                <div class="col-span-2">
                    <input v-model="form.poster_url" @input="clearError('poster_url')" placeholder="Poster URL"
                        :class="inputClass('poster_url')" />
                    <p v-if="errors.poster_url" class="error">{{ errors.poster_url[0] }}</p>
                </div>

                <div class="col-span-2">
                    <input v-model="form.trailer_url" @input="clearError('trailer_url')" placeholder="Trailer URL"
                        :class="inputClass('trailer_url')" />
                    <p v-if="errors.trailer_url" class="error">{{ errors.trailer_url[0] }}</p>
                </div>

                <div class="col-span-2">
                    <textarea v-model="form.description" @input="clearError('description')" placeholder="Description"
                        :class="inputClass('description')" />
                    <p v-if="errors.description" class="error">{{ errors.description[0] }}</p>
                </div>

                <div class="col-span-2">
                    <textarea v-model="form.actors" @input="clearError('actors')" placeholder="Actors"
                        :class="inputClass('actors')" />
                    <p v-if="errors.actors" class="error">{{ errors.actors[0] }}</p>
                </div>

            </div>

            <button @click="editingId ? updateMovie() : createMovie()"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition mb-6">
                {{ editingId ? 'Update Movie' : 'Add Movie' }}
            </button>

            <div v-for="m in movies" :key="m.id"
                class="bg-gray-800 p-4 mb-3 rounded-lg flex justify-between items-center">

                <div>
                    <p class="font-bold text-primary">{{ m.title }}</p>
                    <p class="text-sm text-gray-300">
                        {{ m.genre }} | {{ m.duration }} min
                    </p>
                </div>

                <div class="flex gap-2">
                    <button @click="startEdit(m)" class="bg-green-500 px-3 py-1 rounded text-black">
                        Edit
                    </button>
                    <button @click="deleteMovie(m.id)" class="bg-red-500 px-3 py-1 rounded text-black">
                        Delete
                    </button>
                </div>

            </div>

        </div>

    </div>
</template>

<script>
export default {
    methods: {
        inputClass(field) {
            return [
                'w-full p-3 rounded-lg outline-none',
                this.errors?.[field]
                    ? 'bg-gray-800 border border-red-500'
                    : 'bg-gray-800 focus:ring-2 focus:ring-primary'
            ]
        }
    }
}
</script>

<style>
.error {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 4px;
}
</style>