<script setup>
import { useAuth } from '@/Composables/useAuth'
import { router } from '@inertiajs/vue3'
import { watchEffect } from 'vue'

const { user, isAdmin } = useAuth()

watchEffect(() => {
    if (user.value === null) return

    if (user.value?.role !== 'admin') {
        router.visit('/')
    }
})

const logout = async () => {
    localStorage.removeItem('token')
    localStorage.removeItem('user')

    router.visit('/login')
}
</script>

<template>
<div class="min-h-screen text-white p-10">

    <div class="max-w-4xl mx-auto bg-gray-950 p-7 rounded-lg">

        <h1 class="text-3xl text-red-500 mb-6">Admin Panel</h1>

        <p>Admin: {{ user?.name }}</p>

        <button @click="logout"
                class="mt-6 bg-red-600 px-4 py-2 rounded">
            Logout
        </button>

    </div>

</div>
</template>