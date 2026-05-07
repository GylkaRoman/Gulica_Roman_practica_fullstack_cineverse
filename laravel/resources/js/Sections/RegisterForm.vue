<script setup>
import { ref } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const errors = ref({});

const form = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const register = async () => {
    errors.value = {};

    try {
        await axios.post("/api/auth/register", form.value);
        router.visit("/login");
    } catch (e) {
        if (e.response?.status === 422) {
            errors.value = e.response.data.errors;
        } else {
            console.log(e.response?.data?.message || "Server error");
        }
    }
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center px-4 text-white">
        <div
            class="w-full max-w-md bg-gray-950 p-6 sm:p-8 rounded-2xl shadow-lg"
        >
            <h1
                class="text-2xl sm:text-3xl mb-6 text-primary text-center font-orbitron"
            >
                Register
            </h1>

            <input
                v-model="form.name"
                placeholder="Name"
                class="w-full p-3 mb-2 bg-gray-800 rounded outline-none text-sm sm:text-base"
            />

            <p v-if="errors.name" class="text-red-500 text-xs mb-2">
                {{ errors.name[0] }}
            </p>

            <input
                v-model="form.email"
                placeholder="Email"
                class="w-full p-3 mb-2 bg-gray-800 rounded outline-none text-sm sm:text-base"
            />

            <p v-if="errors.email" class="text-red-500 text-xs mb-2">
                {{ errors.email[0] }}
            </p>

            <input
                v-model="form.password"
                type="password"
                placeholder="Password"
                class="w-full p-3 mb-2 bg-gray-800 rounded outline-none text-sm sm:text-base"
            />

            <p v-if="errors.password" class="text-red-500 text-xs mb-2">
                {{ errors.password[0] }}
            </p>

            <input
                v-model="form.password_confirmation"
                type="password"
                placeholder="Confirm password"
                class="w-full p-3 mb-4 bg-gray-800 rounded outline-none text-sm sm:text-base"
            />

            <button
                @click="register"
                class="w-full bg-primary text-black py-3 rounded-lg font-bold hover:opacity-80 transition"
            >
                Register
            </button>
        </div>
    </div>
</template>
