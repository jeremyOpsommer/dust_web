<template>
    <section id="streamers" class="py-16 bg-gray-800">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-pink-500 mb-8">{{ title }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="streamer in streamers" :key="streamer.name" class="bg-gray-700 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition">
                    <img :src="streamer.image" :alt="streamer.name" class="w-full h-48 object-cover" />
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">{{ streamer.name }}</h3>
                        <p>{{ streamer.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
const props = defineProps({
    title: String,
    streamers: Array
});
</script>
