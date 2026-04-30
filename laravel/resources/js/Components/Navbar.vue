<template>
    <nav class="flex bg-black py-8 px-7 justify-between items-center font-space">
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
        </ul>
        <a class="text-black bg-primary px-5 py-3 rounded-lg" href="">Register</a>
    </nav>
</template>

<script setup>
import logo from '@/assets/cineverse_logo.png'
import { Link } from '@inertiajs/vue3'

</script>