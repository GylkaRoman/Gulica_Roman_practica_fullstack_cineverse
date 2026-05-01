<script setup>
import { useAuth } from '@/Composables/useAuth'
import { router } from '@inertiajs/vue3'
import axios from 'axios'

import { onMounted, ref } from 'vue'

const user = ref(null)

const logout = async () => {
    try {
        const token = localStorage.getItem('token')

        await axios.post('/api/logout', {}, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })
    } catch (e) {
        console.log('logout backend error (ignore)', e)
    }

    localStorage.removeItem('token')

    user.value = null

    router.visit('/login')
}

onMounted(async () => {
    try {
        const token = localStorage.getItem('token')

        const res = await axios.get('/api/profile', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        })

        user.value = res.data

        console.log('USER:', user.value)

    } catch (e) {
        console.error('PROFILE ERROR:', e)
    }
})

</script>

<template>
<div class="min-h-screen bg-black text-white p-10">

    <div class="max-w-2xl mx-auto bg-gray-900 p-8 rounded-2xl">

        <h1 class="text-3xl text-primary mb-6">Profile</h1>

        <p>Name: {{ user?.name }}</p>
        <p>Email: {{ user?.email }}</p>

        <button @click="logout"
                class="mt-6 bg-red-500 px-4 py-2 rounded">
            Logout
        </button>

    </div>

</div>
</template>