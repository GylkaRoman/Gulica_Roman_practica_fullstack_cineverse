<template>
    <footer
        class="bg-gray-950 py-10 sm:py-14 px-4 sm:px-8 lg:px-10 font-space text-primary"
        role="contentinfo"
    >
        <div
            class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-10 lg:gap-0 justify-between"
        >
            <div class="flex flex-col gap-4">
                <div class="flex items-center">
                    <span class="text-primary mr-2 font-semibold text-lg">
                        CineVerse
                    </span>
                    <img :src="logo" class="h-6" alt="CineVerse logo" />
                </div>

                <p class="text-xs sm:text-sm lg:text-base">
                    Email: cineverse@mail.ru
                </p>

                <p class="text-xs sm:text-sm lg:text-base">Chisinau, Moldova</p>

                <p class="text-xs sm:text-sm lg:text-base">
                    Mon - Fri: 10:00 - 22:00
                </p>
            </div>

            <div class="flex flex-col gap-4 sm:gap-5">
                <a
                    href="https://www.facebook.com/"
                    target="_blank"
                    aria-label="Facebook page"
                    class="flex items-center gap-2 hover:opacity-80 transition"
                >
                    <img
                        :src="facebook"
                        class="h-5 sm:h-6"
                        alt="Facebook icon"
                    />
                    <span class="text-xs sm:text-sm lg:text-base"
                        >Facebook</span
                    >
                </a>

                <a
                    href="https://www.instagram.com/"
                    target="_blank"
                    aria-label="Instagram page"
                    class="flex items-center gap-2 hover:opacity-80 transition"
                >
                    <img
                        :src="instagram"
                        class="h-5 sm:h-6"
                        alt="Instagram icon"
                    />
                    <span class="text-xs sm:text-sm lg:text-base"
                        >Instagram</span
                    >
                </a>

                <a
                    href="https://web.telegram.org/"
                    target="_blank"
                    aria-label="Telegram channel"
                    class="flex items-center gap-2 hover:opacity-80 transition"
                >
                    <img
                        :src="telegram"
                        class="h-5 sm:h-6"
                        alt="Telegram icon"
                    />
                    <span class="text-xs sm:text-sm lg:text-base"
                        >Telegram</span
                    >
                </a>

                <a
                    href="https://x.com/"
                    target="_blank"
                    aria-label="X social network page"
                    class="flex items-center gap-2 hover:opacity-80 transition"
                >
                    <img :src="XCOM" class="h-5 sm:h-6" alt="X icon" />
                    <span class="text-xs sm:text-sm lg:text-base">X.com</span>
                </a>
            </div>

            <ul class="flex flex-col gap-4 sm:gap-6">
                <li>
                    <a
                        href="/main"
                        class="relative text-xs sm:text-sm lg:text-base after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full"
                    >
                        Main
                    </a>
                </li>

                <li>
                    <a
                        href="/program"
                        class="relative text-xs sm:text-sm lg:text-base after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full"
                    >
                        Movies
                    </a>
                </li>

                <li>
                    <a
                        href="/price"
                        class="relative text-xs sm:text-sm lg:text-base after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full"
                    >
                        Prices
                    </a>
                </li>

                <li>
                    <a
                        href="/contact"
                        class="relative text-xs sm:text-sm lg:text-base after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full"
                    >
                        Contact
                    </a>
                </li>

                <li>
                    <a
                        href="/rules"
                        class="relative text-xs sm:text-sm lg:text-base after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full"
                    >
                        Rules
                    </a>
                </li>
            </ul>
        </div>

        <div
            class="text-center mt-8 text-[10px] sm:text-xs lg:text-sm opacity-80"
        >
            © 2026 CineVerse. All rights reserved.
        </div>
    </footer>
</template>

<script setup>
import logo from "@/assets/cineverse_logo.png";
import facebook from "@/assets/facebook.svg";
import instagram from "@/assets/instagram.svg";
import telegram from "@/assets/telegram.svg";
import XCOM from "@/assets/X.com.svg";
</script>
