<script setup>
import { ref } from "vue";
import logo from "@/assets/cineverse_logo.png";
import { Link } from "@inertiajs/vue3";
import { useAuth } from "@/Composables/useAuth";

const { isAuth, isAdmin } = useAuth();

const mobileMenuOpen = ref(false);
</script>

<template>
    <nav
        class="bg-gray-950 px-5 md:px-8 py-5 font-space"
        aria-label="Main navigation"
    >
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <span class="text-primary mr-2 font-semibold text-lg">
                    CineVerse
                </span>

                <img :src="logo" alt="CineVerse logo" class="h-6" />
            </div>

            <ul class="hidden lg:flex gap-6 items-center">
                <li>
                    <Link href="/main" class="nav-link"> Main </Link>
                </li>

                <li>
                    <Link href="/program" class="nav-link"> Program </Link>
                </li>

                <li>
                    <Link href="/price" class="nav-link"> Prices </Link>
                </li>

                <li>
                    <Link href="/contact" class="nav-link"> Contact </Link>
                </li>

                <li>
                    <Link href="/rules" class="nav-link"> Rules </Link>
                </li>

                <li v-if="isAdmin">
                    <Link href="/admin" class="nav-link"> Admin </Link>
                </li>
            </ul>

            <div class="hidden lg:flex gap-3 items-center">
                <template v-if="!isAuth">
                    <Link href="/register" class="btn-primary"> Register </Link>

                    <Link href="/login" class="btn-primary"> Login </Link>
                </template>

                <template v-else>
                    <Link href="/profile" class="btn-primary"> Profile </Link>
                </template>
            </div>

            <button
                type="button"
                @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden flex flex-col justify-center items-center w-10 h-10 relative"
                aria-label="Toggle mobile menu"
            >
                <span
                    class="burger-line"
                    :class="mobileMenuOpen ? 'rotate-top' : ''"
                ></span>

                <span
                    class="burger-line"
                    :class="mobileMenuOpen ? 'hide-middle' : ''"
                ></span>

                <span
                    class="burger-line"
                    :class="mobileMenuOpen ? 'rotate-bottom' : ''"
                ></span>
            </button>
        </div>

        <transition name="mobile-menu">
            <div
                v-if="mobileMenuOpen"
                class="lg:hidden mt-6 flex flex-col gap-5"
            >
                <ul class="flex flex-col gap-4">
                    <li>
                        <Link href="/main" class="nav-link-mobile"> Main </Link>
                    </li>

                    <li>
                        <Link href="/program" class="nav-link-mobile">
                            Program
                        </Link>
                    </li>

                    <li>
                        <Link href="/price" class="nav-link-mobile">
                            Prices
                        </Link>
                    </li>

                    <li>
                        <Link href="/contact" class="nav-link-mobile">
                            Contact
                        </Link>
                    </li>

                    <li>
                        <Link href="/rules" class="nav-link-mobile">
                            Rules
                        </Link>
                    </li>

                    <li v-if="isAdmin">
                        <Link href="/admin" class="nav-link-mobile">
                            Admin
                        </Link>
                    </li>
                </ul>

                <div class="flex flex-col gap-3">
                    <template v-if="!isAuth">
                        <Link href="/register" class="btn-primary text-center">
                            Register
                        </Link>

                        <Link href="/login" class="btn-primary text-center">
                            Login
                        </Link>
                    </template>

                    <template v-else>
                        <Link href="/profile" class="btn-primary text-center">
                            Profile
                        </Link>
                    </template>
                </div>
            </div>
        </transition>
    </nav>
</template>

<style>
.nav-link {
    @apply text-primary relative after:content-[''] after:absolute after:left-0 after:-bottom-1 after:h-[2px] after:w-0 after:bg-primary after:transition-all hover:after:w-full;
}

.nav-link-mobile {
    @apply text-primary text-lg block;
}

.btn-primary {
    @apply bg-primary text-black px-4 py-2 rounded-lg font-semibold hover:bg-white transition;
}

.burger-line {
    @apply w-7 h-[3px] bg-primary rounded absolute transition-all duration-300;
}

.burger-line:nth-child(1) {
    transform: translateY(-8px);
}

.burger-line:nth-child(2) {
    transform: translateY(0);
}

.burger-line:nth-child(3) {
    transform: translateY(8px);
}

.rotate-top {
    transform: rotate(45deg) !important;
}

.hide-middle {
    opacity: 0;
}

.rotate-bottom {
    transform: rotate(-45deg) !important;
}

.mobile-menu-enter-active,
.mobile-menu-leave-active {
    transition:
        max-height 0.35s ease,
        opacity 0.25s ease,
        transform 0.25s ease;
    overflow: hidden;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
    max-height: 0;
    opacity: 0;
    transform: translateY(-15px);
}

.mobile-menu-enter-to,
.mobile-menu-leave-from {
    max-height: 500px;
    opacity: 1;
    transform: translateY(0);
}
</style>
