<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'

const { setUser } = useAuth()

const form = ref({
    email: '',
    password: ''
})

const login = async () => {
    const res = await axios.post('/api/auth/login', form.value)

    const token = res.data.access_token

    localStorage.setItem('token', token)

    const profile = await axios.get('/api/profile', {
        headers: {
            Authorization: `Bearer ${token}`
        }
    })

    const user = profile.data.user ?? profile.data

    localStorage.setItem('user', JSON.stringify(user))

    if (user.role === 'admin') {
        router.visit('/admin')
    } else {
        router.visit('/profile')
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-md bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Login
            </h1>

            <input v-model="form.email" placeholder="Email"
                class="w-full p-3 mb-3 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

            <input v-model="form.password" type="password" placeholder="Password"
                class="w-full p-3 mb-5 bg-gray-800 rounded-lg outline-none focus:ring-2 focus:ring-primary" />

            <button @click="login"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition">
                Login
            </button>

        </div>

    </div>
</template>