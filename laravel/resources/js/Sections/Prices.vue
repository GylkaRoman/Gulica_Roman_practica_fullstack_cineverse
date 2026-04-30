<script setup>
import { ref, onMounted } from 'vue'

const prices = ref([])

const fetchPrices = async () => {
    const res = await fetch('/api/prices')
    return await res.json()
}

onMounted(async () => {
    prices.value = await fetchPrices()
})
</script>

<template>
    <div class="container px-8 mt-10 text-white">

        <div class="flex gap-4 flex-wrap bg-black px-5 py-5 rounded-lg text-3xl font-orbitron text-primary mb-6">
            Prices
        </div>

        <div class="grid md:grid-cols-3 gap-10">

            <div v-for="price in prices" :key="price.id"
                class="bg-gray-950 rounded-2xl p-6 shadow-lg hover:border-primary transition text-center">

                <div class="text-xl font-bold mb-2 text-primary">
                    {{ price.type.toUpperCase() }}
                </div>

                <div class="text-primary mb-2">
                    Format: {{ price.format }}
                </div>

                <div class="text-3xl text-primary font-bold mb-4">
                    {{ price.price }} $
                </div>

                <div class="inline-block px-3 py-1 rounded-full" :class="{
                    'bg-teal-600': price.type === 'standard',
                    'bg-red-600': price.type === 'vip',
                    'bg-lime-700': price.type === 'student',
                    'bg-yellow-600': price.type === 'child'
                }">
                    {{ price.type }}
                </div>

            </div>

        </div>

    </div>
</template>