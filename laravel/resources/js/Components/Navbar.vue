<script setup>
import logo from '@/assets/cineverse_logo.png'
import { Link } from '@inertiajs/vue3'
import { useAuth } from '@/Composables/useAuth'

const { isAuth, isAdmin } = useAuth()
</script>

<template>
    <nav class="flex bg-gray-950 py-8 px-7 justify-between items-center font-space">
        <div class="flex">
            <div class="text-primary mr-2">CineVerse</div>
            <img :src="logo" class="h-6" />
        </div>
        <ul class="flex gap-6 items-center">
            <li>
                <Link href="/main"
                    class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Main
                </Link>
            </li>
            <li>
                <Link href="/program"
                    class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Program
                </Link>
            </li>
            <li>
                <Link href="/price"
                    class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Prices
                </Link>
            </li>
            <li>
                <Link href="/contact"
                    class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Contact
                </Link>
            </li>
            <li>
                <Link href="/rules"
                    class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Rules
                </Link>
            </li>
            
            <li v-if="isAdmin">
                <Link href="/admin" class="text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full">
                    Admin
                </Link>
            </li>
        </ul>

        <div class="flex gap-3 items-center">

            <div v-if="!isAuth">
                <Link href="/register" class="bg-primary text-black px-4 py-2 rounded-lg mr-5">
                    Register
                </Link>

                <Link href="/login" class=" bg-primary px-4 py-2 rounded-lg text-black">
                    Login
                </Link>
            </div>

            <div v-else>
                <Link href="/profile" class="bg-primary text-black px-4 py-2 rounded-lg">
                    Profile
                </Link>
            </div>

        </div>
    </nav>
</template>