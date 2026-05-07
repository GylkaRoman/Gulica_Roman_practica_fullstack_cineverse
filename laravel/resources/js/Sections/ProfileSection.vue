<script setup>
import { router } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, ref } from "vue";

const loading = ref(true);

const form = ref({
    name: "",
    email: "",
    old_password: "",
    new_password: "",
    new_password_confirmation: "",
});

const success = ref(null);
const error = ref(null);

const logout = async () => {
    try {
        const token = localStorage.getItem("token");

        await axios.post(
            "/api/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            },
        );
    } catch (e) {
        console.log("logout backend error", e);
    }

    localStorage.removeItem("token");

    router.visit("/login");
};

const updateProfile = async () => {
    success.value = null;
    error.value = null;

    try {
        const token = localStorage.getItem("token");

        await axios.put("/api/profile", form.value, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        success.value = "Profile updated successfully";

        form.value.old_password = "";
        form.value.new_password = "";
        form.value.new_password_confirmation = "";
    } catch (e) {
        if (e.response?.data?.message) {
            error.value = e.response.data.message;
        } else if (e.response?.data?.errors) {
            error.value = Object.values(e.response.data.errors)
                .flat()
                .join(" ");
        } else {
            error.value = "Update failed";
        }
    }
};

onMounted(async () => {
    try {
        const token = localStorage.getItem("token");

        const res = await axios.get("/api/profile", {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        form.value.name = res.data.name;
        form.value.email = res.data.email;
    } catch (e) {
        console.error("PROFILE ERROR:", e);
    } finally {
        loading.value = false;
    }
});
</script>

<template>
    <main
        class="min-h-screen bg-black text-white px-4 sm:px-10 py-10 flex items-center justify-center"
    >
        <section
            class="w-full max-w-xl bg-gray-900 p-6 sm:p-8 rounded-2xl shadow-xl"
        >
            <h1 class="text-2xl sm:text-3xl text-primary font-bold mb-6">
                Profile
            </h1>

            <div v-if="loading" class="text-gray-400">Loading profile...</div>

            <form v-else @submit.prevent="updateProfile" class="space-y-4">
                <div v-if="success" class="bg-green-600 text-white p-3 rounded">
                    {{ success }}
                </div>

                <div v-if="error" class="bg-red-600 text-white p-3 rounded">
                    {{ error }}
                </div>

                <div>
                    <label class="block mb-1 text-primary"> Name </label>

                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full p-3 rounded bg-gray-800 text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-primary"> Email </label>

                    <input
                        v-model="form.email"
                        type="email"
                        class="w-full p-3 rounded bg-gray-800 text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-primary">
                        Old Password
                    </label>

                    <input
                        v-model="form.old_password"
                        type="password"
                        class="w-full p-3 rounded bg-gray-800 text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-primary">
                        New Password
                    </label>

                    <input
                        v-model="form.new_password"
                        type="password"
                        class="w-full p-3 rounded bg-gray-800 text-white"
                    />
                </div>

                <div>
                    <label class="block mb-1 text-primary">
                        Confirm New Password
                    </label>

                    <input
                        v-model="form.new_password_confirmation"
                        type="password"
                        class="w-full p-3 rounded bg-gray-800 text-white"
                    />
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button
                        type="submit"
                        class="bg-primary text-black px-5 py-3 rounded-lg font-bold hover:opacity-80 transition"
                    >
                        Save Changes
                    </button>

                    <button
                        type="button"
                        @click="router.visit('/my-bookings')"
                        class="bg-blue-600 text-white px-5 py-3 rounded-lg font-bold hover:bg-blue-500 transition"
                    >
                        My Bookings
                    </button>

                    <button
                        type="button"
                        @click="logout"
                        class="bg-red-500 text-white px-5 py-3 rounded-lg font-bold hover:bg-red-400 transition"
                    >
                        Logout
                    </button>
                </div>
            </form>
        </section>
    </main>
</template>
