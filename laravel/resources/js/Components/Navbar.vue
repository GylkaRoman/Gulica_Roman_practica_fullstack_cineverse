<script setup>
import logo from '@/assets/cineverse_logo.png'
import { Link } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'

const { isAuth, isAdmin } = useAuth()
</script>

<template>
    <nav class="flex bg-gray-950 py-6 px-8 justify-between items-center font-space">

        <div class="flex items-center">
            <span class="text-primary mr-2 font-semibold text-lg">CineVerse</span>
            <img :src="logo" alt="CineVerse logo" class="h-6" />
        </div>

        <ul class="flex gap-6 items-center">

            <li>
                <Link href="/main" class="nav-link">Main</Link>
            </li>

            <li>
                <Link href="/program" class="nav-link">Program</Link>
            </li>

            <li>
                <Link href="/price" class="nav-link">Prices</Link>
            </li>

            <li>
                <Link href="/contact" class="nav-link">Contact</Link>
            </li>

            <li>
                <Link href="/rules" class="nav-link">Rules</Link>
            </li>

            <li v-if="isAdmin">
                <Link href="/admin" class="nav-link">Admin</Link>
            </li>

        </ul>

        <div class="flex gap-3 items-center">

            <template v-if="!isAuth">
                <Link href="/register" class="btn-primary">Register</Link>
                <Link href="/login" class="btn-primary">Login</Link>
            </template>

            <template v-else>
                <Link href="/profile" class="btn-primary">Profile</Link>
            </template>

        </div>

    </nav>
</template>

<style>
.nav-link {
    @apply text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full;
}

.btn-primary {
    @apply bg-primary text-black px-4 py-2 rounded-lg;
}
</style>