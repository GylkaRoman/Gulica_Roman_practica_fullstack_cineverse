<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const movies = ref([])
const editingId = ref(null)

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

const startEdit = (movie) => {
    editingId.value = movie.id

    form.value = {
        title: movie.title,
        original_title: movie.original_title,
        description: movie.description,
        poster_url: movie.poster_url,
        trailer_url: movie.trailer_url,
        genre: movie.genre,
        duration: movie.duration,
        age_rating: movie.age_rating,
        director: movie.director,
        actors: movie.actors
    }
}

const updateMovie = async () => {
    await axios.put(`/api/movies/${editingId.value}`, form.value, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    })

    resetForm()
    editingId.value = null
    fetchMovies()
}

const fetchMovies = async () => {
    const res = await axios.get('/api/movies')
    movies.value = res.data.data ?? res.data
}

onMounted(fetchMovies)

const createMovie = async () => {
    await axios.post('/api/movies', form.value, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    })

    resetForm()
    fetchMovies()
}

const deleteMovie = async (id) => {
    await axios.delete(`/api/movies/${id}`, {
        headers: {
            Authorization: `Bearer ${token}`
        }
    })

    fetchMovies()
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
}
</script>
<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-3xl bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Movies Admin
            </h1>

            <div class="grid grid-cols-2 gap-3 mb-6">

                <input v-model="form.title" placeholder="Title"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.original_title" placeholder="Original Title"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.genre" placeholder="Genre"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.duration" placeholder="Duration"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.age_rating" placeholder="Age rating"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.director" placeholder="Director"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

                <input v-model="form.poster_url" placeholder="Poster URL"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary col-span-2" />

                <input v-model="form.trailer_url" placeholder="Trailer URL"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary col-span-2" />

                <textarea v-model="form.description" placeholder="Description"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary col-span-2"></textarea>

                <textarea v-model="form.actors" placeholder="Actors"
                    class="w-full p-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary col-span-2"></textarea>

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