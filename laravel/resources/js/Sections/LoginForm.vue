<script setup>
import { ref } from "vue";
import axios from "axios";
import { router } from "@inertiajs/vue3";

const form = ref({
    email: "",
    password: "",
});

const errors = ref({});
const loading = ref(false);

const login = async () => {
    errors.value = {};
    loading.value = true;

    try {
        const res = await axios.post("/api/auth/login", form.value);

        const token = res.data.access_token;
        localStorage.setItem("token", token);

        const profile = await axios.get("/api/profile", {
            headers: { Authorization: `Bearer ${token}` },
        });

        const user = profile.data.user ?? profile.data;
        localStorage.setItem("user", JSON.stringify(user));

        router.visit(user.role === "admin" ? "/admin" : "/profile");
    } catch (err) {
        if (err.response?.status === 422) {
            errors.value = err.response.data.errors;
        } else if (err.response?.status === 401) {
            errors.value = { general: ["Invalid email or password"] };
        } else {
            errors.value = { general: ["Something went wrong"] };
        }
    }

    loading.value = false;
};
</script>

<template>
    <div class="min-h-screen flex items-center justify-center px-4 text-white">
        <div
            class="w-full max-w-md bg-gray-950 p-6 sm:p-8 rounded-2xl shadow-lg"
        >
            <h1
                class="text-2xl sm:text-3xl font-orbitron text-primary mb-6 text-center"
            >
                Login
            </h1>

            <p
                v-if="errors.general"
                class="text-red-500 text-sm mb-3 text-center"
            >
                {{ errors.general[0] }}
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
                class="w-full p-3 mb-4 bg-gray-800 rounded outline-none text-sm sm:text-base"
            />

            <p v-if="errors.password" class="text-red-500 text-xs mb-4">
                {{ errors.password[0] }}
            </p>

            <button
                @click="login"
                class="w-full bg-primary text-black font-bold py-3 rounded-lg hover:opacity-80 transition disabled:opacity-50"
                :disabled="loading"
            >
                {{ loading ? "Loading..." : "Login" }}
            </button>
        </div>
    </div>
</template>
