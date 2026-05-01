<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

const register = async () => {
    await axios.post('/api/auth/register', form.value)

    router.visit('/login')
}
</script>

<template>
<div class="min-h-screen flex items-center justify-center text-white">

    <div class="w-full max-w-md bg-gray-900 p-8 rounded-2xl">

        <h1 class="text-3xl mb-6 text-primary text-center">Register</h1>

        <input v-model="form.name" placeholder="Name" class="w-full p-3 mb-3 bg-gray-800 rounded"/>
        <input v-model="form.email" placeholder="Email" class="w-full p-3 mb-3 bg-gray-800 rounded"/>
        <input v-model="form.password" type="password" placeholder="Password" class="w-full p-3 mb-3 bg-gray-800 rounded"/>
        <input v-model="form.password_confirmation" type="password" placeholder="Confirm" class="w-full p-3 mb-5 bg-gray-800 rounded"/>

        <button @click="register"
                class="w-full bg-primary text-black py-3 rounded">
            Register
        </button>

    </div>

</div>
</template>