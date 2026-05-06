<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'
const errors = ref({})

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const register = async () => {
    errors.value = {}

    try {
        await axios.post('/api/auth/register', form.value)

        router.visit('/login')

    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors
        } else {
            console.log(e.response?.data?.message || 'Server error')
        }
    }
}
</script>

<template>
    <div class="min-h-screen flex items-center justify-center text-white">

        <div class="w-full max-w-md bg-gray-900 p-8 rounded-2xl">

            <h1 class="text-3xl mb-6 text-primary text-center">Register</h1>

            <input v-model="form.name" placeholder="Name" class="w-full p-3 mb-3 bg-gray-800 rounded"  required/>
            <input v-model="form.email" placeholder="Email" class="w-full p-3 mb-3 bg-gray-800 rounded"  required/>
            <input v-model="form.password" type="password" placeholder="Password" required
                class="w-full p-3 mb-3 bg-gray-800 rounded" />
            <input v-model="form.password_confirmation" type="password" placeholder="Confirm" required
                class="w-full p-3 mb-5 bg-gray-800 rounded" />

            <button @click="register" class="w-full bg-primary text-black py-3 rounded">
                Register
            </button>

            <p v-if="errors.name" class="text-red-500 text-sm">
                {{ errors.name[0] }}
            </p>

            <p v-if="errors.email" class="text-red-500 text-sm">
                {{ errors.email[0] }}
            </p>

            <p v-if="errors.password" class="text-red-500 text-sm">
                {{ errors.password[0] }}
            </p>
        </div>

    </div>
</template>