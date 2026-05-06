<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const form = ref({
    email: '',
    password: ''
})

const errors = ref(null)
const loading = ref(false)

const login = async () => {
    errors.value = null
    loading.value = true

    try {
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

    } catch (err) {

        if (err.response?.status === 422) {
            errors.value = err.response.data.errors
        }

        else if (err.response?.status === 401) {
            errors.value = {
                general: ['Invalid email or password']
            }
        }

        else {
            errors.value = {
                general: ['Something went wrong']
            }
        }
    }

    loading.value = false
}
</script>
<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-md bg-gray-950 p-8 rounded-2xl shadow-lg">

            <h1 class="text-3xl font-bold text-primary mb-6 text-center">
                Login
            </h1>

            <p v-if="errors?.general" class="text-red-500 mb-3 text-center">
                {{ errors.general[0] }}
            </p>

            <input v-model="form.email" placeholder="Email" required
                class="w-full p-3 mb-1 bg-gray-800 rounded-lg outline-none" />

            <p v-if="errors?.email" class="text-red-500 text-sm mb-2">
                {{ errors.email[0] }}
            </p>

            <input v-model="form.password" type="password" placeholder="Password" required
                class="w-full p-3 mb-1 bg-gray-800 rounded-lg outline-none" />

            <p v-if="errors?.password" class="text-red-500 text-sm mb-4">
                {{ errors.password[0] }}
            </p>

            <button @click="login"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition"
                :disabled="loading">
                {{ loading ? 'Loading...' : 'Login' }}
            </button>

        </div>

    </div>
</template>