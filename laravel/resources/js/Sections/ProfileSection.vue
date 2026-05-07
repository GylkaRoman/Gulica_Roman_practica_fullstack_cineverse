<script setup>
import { router, Head } from '@inertiajs/vue3'
import axios from 'axios'

import { onMounted, ref } from 'vue'

const user = ref(null)
const loading = ref(true)

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

    } catch (e) {
        console.error('PROFILE ERROR:', e)
    } finally {
        loading.value = false
    }
})
</script>

<template>

    <main class="min-h-screen bg-black text-white p-10">

        <section class="max-w-2xl mx-auto bg-gray-900 p-8 rounded-2xl shadow-xl" aria-labelledby="profile-heading">

            <h1 id="profile-heading" class="text-3xl text-primary mb-6 font-bold">
                Profile
            </h1>

            <div v-if="loading" class="text-gray-400">
                Loading profile...
            </div>

            <div v-else-if="user">

                <div class="space-y-3 text-lg">

                    <p>
                        <span class="text-primary font-semibold">
                            Name:
                        </span>

                        {{ user.name }}
                    </p>

                    <p>
                        <span class="text-primary font-semibold">
                            Email:
                        </span>

                        {{ user.email }}
                    </p>

                </div>

                <div class="flex flex-wrap gap-4 mt-8">

                    <button type="button" @click="router.visit('/my-bookings')" aria-label="Open my bookings page"
                        class="bg-primary text-black px-5 py-3 rounded-lg font-bold hover:bg-white transition focus:outline-none focus:ring-2 focus:ring-primary">
                        My Bookings
                    </button>

                    <button type="button" @click="logout" aria-label="Logout from account"
                        class="bg-red-500 px-5 py-3 rounded-lg font-bold hover:bg-red-400 transition focus:outline-none focus:ring-2 focus:ring-red-500">
                        Logout
                    </button>

                </div>

            </div>

        </section>

    </main>

</template>